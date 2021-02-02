<?php
class Tools
{
    static function connect(
        $host = "localhost:3306",
        $dbname = "storedb",
        $user = "root",
        $pass = "root"
    ) {
        $connectionString = "mysql:host=" . $host . "; dbname=" . $dbname . "; charset=utf8";
        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        );

        try {
            $pdo = new PDO($connectionString, $user, $pass, $option);
            return $pdo;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    static function registration($login, $pass, $email, $photo)
    {
        $login = trim(htmlspecialchars($login));
        $pass = trim(htmlspecialchars($pass));
        $email = trim(htmlspecialchars($email));
        if (strlen($login) > 2 && strlen($pass) > 2 && strlen($email) > 0 && $photo !== null) {
            $pass = md5($pass);
            $images = $photo['input__file'];
            $imgPath = Tools::moveImages($images);
            $newCustomer = new Customer($login, $pass, $email, $imgPath);
            if ($newCustomer->push_to_db())
                return true;
            else
                return false;
        }
        return false;
    }

    static function authorization($login, $pass)
    {
        $user = Customer::getByLogin($login);
        if ($user && $user->pass === md5($pass)) {
            $_SESSION['login'] = $login;
            if ($user->roleId == 1) {
                $_SESSION['admin'] = $login;
            }
        } else {
            echo "<h3 align='center' style='color: red'>Неверный пароль</h3>";
            return false;
        }
        return true;
    }

    static function checkAuthorization()
    {
        if (strlen($_SESSION['login']) > 0) {
            return true;
        }
        return false;
    }

    static function moveImages($images)
    {
        for ($i = 0; $i < count($images["name"]); $i++) {
            if ($images && $images["error"][$i] == UPLOAD_ERR_OK) {
                $imgName = $images["name"][$i];
                $imgName = str_replace(" ", "_", $imgName);
                $imgName = "FILES/IMAGES/" . $imgName;
                if (!file_exists($imgName)) {
                    move_uploaded_file($images["tmp_name"][$i], $imgName);
                }
            }
        }
        return $imgName;
    }
}

class Customer
{
    public $id;
    public $login;
    public $pass;
    public $email;
    public $roleId;
    public $avatar;
    public $discount;
    public $total;

    function __construct($login, $pass, $email, $avatar, $id = 0)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->id = $id;
        $this->roleId = 2;
        $this->discount = 0;
        $this->total = 0;
    }

    function push_to_db()
    {
        try {
            $pdo = Tools::connect();
            $arr = (array)$this;
            array_shift($arr);
            $ps = $pdo->prepare("INSERT INTO Customers(login, pass, email, roleId, avatar, discount, total) VALUES(:login, :pass, :email, :roleId, :avatar, :discount, :total)");
            $ps->execute($arr);
            $this->id = $pdo->lastInsertId();
            return true;
        } catch (PDOException $ex) {
            $err = $ex->getMessage();
            if (substr($err, 0, strpos($err, ":")) == "SQLSTATE[23000]")
                return 1062;
            else return $err;
        }
    }

    static function getById($id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Customers WHERE id=?");
            $ps->execute(array($id));
            $row = $ps->fetch();
            $customer = new Customer($row['login'], $row['pass'], $row['email'], $row['avatar'], $row['id']);
            $customer->total = $row['total'];
            $customer->discount = $row['discount'];
            $customer->roleId = $row['roleId'];
            return $customer;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
    static function getAll()
    {
        try {
            $customers = [];
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Customers");
            $ps->execute();
            while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
                $customer = new Customer($row['login'], $row['pass'], $row['email'], $row['avatar'], $row['id']);
                $customer->total = $row['total'];
                $customer->discount = $row['discount'];
                $customer->roleId = $row['roleId'];
                array_push($customers, $customer);
            }
            return $customers;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    static function getByLogin($login)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Customers WHERE login=?");
            $ps->execute(array($login));
            $row = $ps->fetch();
            $customer = new Customer($row['login'], $row['pass'], $row['email'], $row['avatar'], $row['id']);
            $customer->total = $row['total'];
            $customer->discount = $row['discount'];
            $customer->roleId = $row['roleId'];
            return $customer;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}

class Category
{
    public $id;
    public $category;
    function __construct($category, $id = 0)
    {
        $this->category = $category;
        $this->id = $id;
    }

    function push_to_db()
    {
        try {
            $pdo = Tools::connect();
            $arr = (array)$this;
            array_shift($arr);
            $ps = $pdo->prepare("INSERT INTO Categories(category) VALUES(:category)");
            $ps->execute($arr);
            $this->id = $pdo->lastInsertId();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function delete($categoriesId)
    {
        try {
            $pdo = Tools::connect();
            foreach ($categoriesId as $id) {
                $ps = $pdo->prepare("DELETE FROM Categories WHERE id=?");
                $ps->execute(array($id));
            }
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getById($id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Categories WHERE id=?");
            $ps->execute(array($id));
            $row = $ps->fetch();
            $category = new Category($row['category'], $row['id']);
            return $category;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
    static function getAll()
    {
        try {
            $categories = [];
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Categories");
            $ps->execute();
            while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
                $category = new Category($row['category'], $row['id']);
                array_push($categories, $category);
            }
            return $categories;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}

class Good
{
    public $id;
    public $good;
    public $categoryId;
    public $priceIn;
    public $priceSale;
    public $info;
    public $rate;
    public $action;

    function __construct($good, $categoryId, $priceIn, $priceSale, $info, $id = 0, $rate = 0, $action = 0)
    {
        $this->id = $id;
        $this->good = $good;
        $this->categoryId = $categoryId;
        $this->priceIn = $priceIn;
        $this->priceSale = $priceSale;
        $this->info = $info;
        $this->rate = $rate;
        $this->action = $action;
    }

    function push_to_db($image = null)
    {
        try {
            $pdo = Tools::connect();
            $arr = (array)$this;
            array_shift($arr);
            $ps = $pdo->prepare("INSERT INTO Goods(good, categoryId, priceIn, priceSale, info, rate, action) VALUES (:good, :categoryId, :priceIn, :priceSale, :info, :rate, :action)");
            $ps->execute($arr);
            $this->id = $pdo->lastInsertId();
            if ($image == null) {
                $path = 'FILES/STATICIMAGES/no_image.jpg';
            } else {
                $path = Tools::moveImages($image);
            }
            $img = new Image($this->id, $path);
            $img->push_to_db();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function delete($goodsId)
    {
        try {
            $pdo = Tools::connect();
            foreach ($goodsId as $id) {
                $ps = $pdo->prepare("DELETE FROM Goods WHERE id=?");
                $ps->execute(array($id));
            }
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getById($id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Goods where id=?");
            $ps->execute(array($id));
            $row = $ps->fetch();
            $good = new Good($row['good'], $row['categoryId'], $row['priceIn'], $row['priceSale'], $row['info'], $row['id'], $row['rate'], $row['action']);
            return $good;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getAll()
    {
        try {
            $pdo = Tools::connect();
            $goods = [];
            $ps = $pdo->prepare("SELECT * FROM Goods");
            $ps->execute();
            while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
                $good = new Good($row['good'], $row['categoryId'], $row['priceIn'], $row['priceSale'], $row['info'], $row['id'], $row['rate'], $row['action']);
                array_push($goods, $good);
            }
            return $goods;
        } catch (PDOException $ex) {
            return false;
        }
    }

    function buy()
    {
        if (isset($_SESSION['login'])) {
            $customer = Customer::getByLogin($_SESSION['login']);
            $sale = new Sale($this->id, $customer->id);
            $sale->push_to_db();
        } else {
            $sale = new Sale($this->id);
            $sale->push_to_db();
        }


        // Good::delete([$this->id]);
    }
}

class Image
{
    public $id;
    public $goodId;
    public $imagepath;

    function __construct($goodId, $imagepath, $id = 0)
    {
        $this->id = $id;
        $this->goodId = $goodId;
        $this->imagepath = $imagepath;
    }

    function push_to_db()
    {
        try {
            $pdo = Tools::connect();
            $arr = (array)$this;
            array_shift($arr);
            $ps = $pdo->prepare("INSERT INTO Images(goodId,imagepath) VALUES (:goodId, :imagepath)");
            $ps->execute($arr);
            $this->id = $pdo->lastInsertId();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function delete($imagesId)
    {
        try {
            $pdo = Tools::connect();
            foreach ($imagesId as $id) {
                $ps = $pdo->prepare("DELETE FROM Images WHERE id=?");
                $ps->execute(array($id));
            }
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getById($id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Images where id=?");
            $ps->execute(array($id));
            $row = $ps->fetch();
            $image = new Image($row['goodId'], $row['imagepath'], $row['id']);
            return $image;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getAll()
    {
        try {
            $pdo = Tools::connect();
            $images = [];
            $ps = $pdo->prepare("SELECT * FROM Images");
            $ps->execute();
            while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
                $image = new Image($row['goodId'], $row['imagepath'], $row['id']);
                array_push($images, $image);
            }
            return $images;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getImageByGoodId($goodId)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Images where goodId=?");
            $ps->execute(array($goodId));
            $row = $ps->fetch();
            $image = new Image($row['goodId'], $row['imagepath'], $row['id']);
            return $image;
        } catch (PDOException $ex) {
            return false;
        }
    }
}


class Sale
{
    public $id;
    public $goodId;
    public $customerId;
    public $quantity;
    public $date;
    function __construct($goodId, $customerId = 0, $quantity = 1, $id = 0)
    {
        $this->goodId = $goodId;
        $this->customerId = $customerId;
        $this->quantity = $quantity;
        $this->date = date("m.d.y");
        $this->id = $id;
    }

    function push_to_db()
    {
        try {
            $this->date = date('Y-m-d', strtotime(str_replace('-', '/', $this->date)));
            $pdo = Tools::connect();
            $arr = (array)$this;
            array_shift($arr);
            $ps = $pdo->prepare("INSERT INTO Sales(goodId, customerId, quantity, date) VALUES(:goodId, :customerId, :quantity, :date)");
            $ps->execute($arr);
            $this->id = $pdo->lastInsertId();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    static function getById($id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Sales WHERE id=?");
            $ps->execute(array($id));
            $row = $ps->fetch();
            $sale = new Sale($row['goodId'], $row['customerId'], $row['quantity'], $row['date'], $row['id']);
            return $sale;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    static function getAll()
    {
        try {
            $sales = [];
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM Sales");
            $ps->execute();
            while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
                $sale = new Sale($row['goodId'], $row['customerId'], $row['quantity'], $row['date'], $row['id']);
                array_push($sales, $sale);
            }
            return $sales;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}