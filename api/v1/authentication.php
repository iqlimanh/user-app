<?php 
$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["username"] = $session['username'];
    $response["email"] = $session['email'];
    $response["user_id"] = $session['user_id'];
    $response["staff_id"] = $session['staff_id'];
    $response["created"] = $session['created'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('user_id', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $password = $r->customer->password;
    $user_id = $r->customer->user_id;
    $user = $db->getOneRecord("select * from user where user_id='$user_id'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['username'] = $user['username'];
        $response['uid'] = $user['uid'];
        $response['user_id'] = $user['user_id'];
        $response['email'] = $user['email'];
        $response['created'] = $user['created'];
        $response['staff_id'] = $user['staff_id'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user['username'];
        $_SESSION['staff_id'] = $user['staff_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['created'] = $user['created'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('user_id', 'email', 'username', 'password', 'staff_id'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $user_id = $r->customer->$user_id;
    $username = $r->customer->username;
    $email = $r->customer->email;
    $staff_id = $r->customer->staff_id;
    $password = $r->customer->password;
    $isUserExists = $db->getOneRecord("select 1 from user where staff_id='$staff_id' or user_id='$user_id'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
        $tabble_name = "user";
        $column_names = array('user_id', 'username', 'email', 'password', 'staff_id');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = 'User account created successfully';
            $response["uid"] = $result;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = 'Failed to create customer. Please try again';
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = 'An user with the provided phone or email exists!';
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>