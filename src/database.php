<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$conn->select_db("phpMyAdmin");

$table1 = "CREATE TABLE IF NOT EXISTS REGISTER (
            id INT(4) PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(100) NOT NULL,
            code VARCHAR(100) NOT NULL,
            createdAt VARCHAR(100) NOT NULL)";

$table2 = "CREATE TABLE IF NOT EXISTS USERS (
            id INT(4) PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(100) NOT NULL,
            name VARCHAR(100) NOT NULL)";

$table3 = "CREATE TABLE IF NOT EXISTS LOGINS (
            id INT(4) PRIMARY KEY AUTO_INCREMENT,
            userId INT(4) NOT NULL,
            code VARCHAR(100) NOT NULL,
            createdAt VARCHAR(100) NOT NULL)";

if ($conn->query($table1) === TRUE && $conn->query($table2) === TRUE && $conn->query($table3) === TRUE) {
    echo "Tables created successfully!";
}

function createRegister($email, $code) {
    global $servername, $username, $password;

    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->select_db('phpMyAdmin');

    try {
        $stmt = $conn->prepare("INSERT INTO REGISTER (email, code, createdAt) VALUES (?, ?, ?)");

        $createdAt = (new DateTime())->format('c'); 
        $stmt->bind_param('sss', $email, $code, $createdAt);

        $stmt->execute();

       return $stmt->affected_rows === 1;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        $conn->close();
    }
}

function getRegister($code) {
    global $servername, $username, $password;

    $conn = new mysqli($servername, $username, $password);
    $conn->select_db('phpMyAdmin');

    try {
        $stmt = $conn->prepare("SELECT * FROM REGISTER WHERE CODE = ?");
        if ($stmt === false) {
            throw new Exception("Error in preparing the SQL statement");
        }

        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_assoc();
        return isset($record['id']) ? $record : null;        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn->close();
    }
}

function createUser($email, $name) {
    global $servername, $username, $password;

    $conn = new mysqli($servername, $username, $password);
    $conn->select_db('phpMyAdmin');
    
    try {
        $stmt = $conn->prepare("INSERT INTO USERS (email, name) VALUES (?, ?)");
        $stmt->bind_param('ss', $email, $name);
        $stmt->execute();
        return $stmt->affected_rows===1;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn->close();
    }
}

function deleteRegister($id){
    global $username,$password,$servername;
    $conn=new mysqli($servername,$username,$password);
    $conn->select_db('phpMyAdmin');

    try{
        $stmt = $conn->prepare('DELETE FROM REGISTER WHERE ID = ?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        return $stmt->affected_rows===1;

    }  catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn->close();
    }
}

function findUser($id){
    global $servername,$username,$password;
    $conn = new mysqli($servername,$username,$password);
    $conn->select_db('phpMyAdmin');
    try{
        $stmt = $conn->prepare('SELECT * FROM USERS WHERE ID = ?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result=$stmt->get_result();
        $record=$result->fetch_assoc();
        return isset($record['id']) ? $record :null;
    }
    catch(Exception $e){
        echo "Error";
    }
    finally{
        $conn->close();
    }
}

function getUser($email){
    global $servername,$username,$password;
    $conn = new mysqli($servername,$username,$password);
    $conn->select_db('phpMyAdmin');

    try{
        $stmt = $conn->prepare('SELECT * FROM USERS WHERE EMAIL = ?');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result=$stmt->get_result();
        $record=$result->fetch_assoc();
        return isset($record['id']) ? $record :null;
    }
    catch(Exception $e){
        echo "Error";
    }
    finally{
        $conn->close();
    }
}

function createLogin($userId,$code){
    global $servername,$username,$password;
    $conn = new mysqli($servername,$username,$password);
    $conn->select_db('phpMyAdmin');

    try{
        $date = (new DateTime())->format('c');
        $stmt = $conn->prepare('INSERT INTO LOGINS(userId,code,date) VALUES (?,?,?)');
        $stmt->bind_param('iss',$userId,$code,$date);
        $stmt->execute();
        return $stmt->affected_rows() === 1;
    }
    catch(Exception $e){
        echo "Error";
    }
    finally{
        $conn->close();
    }
}

function getLogin($code){
    try{
        $stmt = $conn->prepare('SELECT * FROM LOGINS WHERE CODE = ?');
        $stmt->bind_param('s',$code);
        $stmt->execute();
        $result=$stmt->get_result();
        $record=$result->fetch_assoc();
        return isset($record['id']) ? $record :null;
        }
    catch(Exception $e){
        echo "Error";
    }
    finally{
        $conn->close();
    }
}

function deleteLogin($id){
    try{
        $stmt = $conn->prepare('DELETE FROM LOGINS WHERE ID = ?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        return $stmt->affected_rows() === 1;
        }
    catch(Exception $e){
        echo "Error";
    }
    finally{
        $conn->close();
    }
}

$conn->close();
?>
