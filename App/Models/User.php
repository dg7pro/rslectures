<?php

namespace App\Models;

use App\Flash;
use App\Initials;
use App\Lib\Helpers;
use App\Mail;
use App\Token;
use Core\Model;
use Core\View;
use PDO;
use Faker;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    /**
     * User constant
     */
    const USER = true;

    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /**
     * User constructor.
     * @param array $data
     */
    public function __construct($data=[])
    {
        foreach ($data as $key => $value){
            $this->$key=$value;
        }
    }

    /* **************************************
     * Section 1
     * Signup User Functions
     * ***************************************
     * */

    /**
     * Save user information into database
     *
     * @return bool|false
     */
    public function save(): bool
    {

        $this->validate();

        if(empty($this->errors)){
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            //$pid = self::generateProfileId(7);
            //$avatar = self::getDefaultAvatar($this->gender);

            $token = new Token();
            $hashed_token = $token->getHash();             // Saved in users table
            $this->activation_token = $token->getValue();  // To be send in email

            $tnc = isset($this->i_agree)? 1 : 0;

            /*$referred_id =null;
            if($this->referred_by!=''){
                $referred_id = self::getReferredByUserId($this->referred_by);
            }*/

            $sql = 'INSERT INTO users (email, mobile, password_hash, first_name, last_name, activation_hash, tnc)
                    VALUES (:email, :mobile, :password_hash, :first_name, :last_name, :activation_hash, :tnc)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':mobile', $this->mobile, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':first_name', ucfirst($this->first_name), PDO::PARAM_STR);
            $stmt->bindValue(':last_name', ucfirst($this->last_name), PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);
            $stmt->bindValue(':tnc', $tnc, PDO::PARAM_BOOL);


            //return $stmt->execute();

            $stmt->execute();
            $uid = $db->lastInsertId();

            // Persist unique user code
            $this->persistUserCode($uid);

            return $uid;

        }

        return false;
    }

    /**
     * @param $new_id
     * @return bool
     */
    public function persistUserCode($new_id): bool
    {

        $name = $this->first_name.' '.$this->last_name;

        $initial = $this->generate($name);

        $uc = $initial.date("y").date("m").$new_id;

        $sql = "UPDATE users SET code=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$uc,$new_id]);

    }

    /**
     * Generate initials from a name
     *
     * @param string $name
     * @return string
     */
    public function generate(string $name) : string
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        }
        return $this->makeInitialsFromSingleWord($name);
    }

    /**
     * Make initials from a word with no spaces
     *
     * @param string $name
     * @return string
     */
    protected function makeInitialsFromSingleWord(string $name) : string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return substr(implode('', $capitals[1]), 0, 2);
        }
        return strtoupper(substr($name, 0, 2));
    }


    /**
     * Validate User Input
     */
    public function validate(){

        if (!preg_match("/^([a-zA-Z]{3,30})/",$this->first_name)) {
            $this->errors[] = 'Please check your first name';
        }

        if (!preg_match("/^([a-zA-Z]{3,20})$/",$this->last_name)) {
            $this->errors[] = 'Please check your last name';
        }


        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }

        if($this->emailExists($this->email)){
            $this->errors[] = 'Email already exists';
        }

        // mobile address
        if (!preg_match("/^[6-9]\d{9}$/",$this->mobile)) {
            $this->errors[] = 'Invalid mobile number';
        }

        if($this->mobileExists($this->mobile)){
            $this->errors[] = 'Mobile already exists';
        }

        // password
        if (strlen($this->password) < 7) {
            $this->errors[] = 'Password must be at least 7 characters or more';
        }

        if (!isset($this->i_agree)) {
            $this->errors[] = 'Please agree with Terms and Condition';
        }


    }

    /**
     * @param $size
     * @return string
     */
    public static function generateProfileId($size){

        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }

        $length = $size - 2;

        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $alpha_key . $key;

    }

    /**
     * @param $gender
     * @return string
     */
    public static function getDefaultAvatar($gender){

        return $gender==1?'avatar_groom.jpg':'avatar_bride.jpg';
    }

    /* **************************************
     * Section 2
     * Login User Functions
     * ***************************************
     * */

    /**
     * @param $email
     * @param $password
     * @return false|mixed
     */
    public static function authenticate($email, $password){

        $user = static::findByEmail($email);
        if($user){
            if(password_verify($password,$user->password_hash)){
                return $user;
            }
        }
        return false;
    }

    /**
     * Used to remember user at database level
     * @return bool
     */
    public function rememberLogin(){

        $token = new Token();
        $hashed_token = $token->getHash();

        $this->remember_token = $token->getValue();
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;

        $sql = "INSERT INTO remembered_logins (token_hash, user_id, expires_at) 
                VALUES (:token_hash, :user_id, :expires_at)";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $hashed_token,PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /* **************************************
      * Section - 3
      * Find User Functions
      * ***************************************
      * */

    /**
     * @param $email
     * @param null $ignore_id
     * @return bool
     */
    public function emailExists($email, $ignore_id=null){

        $user = static::findByEmail($email);

        if($user){
            if($user->id !=$ignore_id){
                return true;
            }
        }
        return false;

    }

    /**
     * @param $mobile
     * @param string $ignore_id
     * @return bool
     */
    public function mobileExists($mobile, $ignore_id=''){

        $user = static::findByMobile($mobile);

        if($user){
            if($ignore_id != $user->id){
                return true;
            }
        }
        return false;

    }

    /**
     * @param $email
     * @return mixed
     */
    public static function findByEmail($email){

        $sql = "SELECT * FROM users WHERE email= :email";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param $mobile
     * @return mixed
     */
    public static function findByMobile($mobile){

        $sql = "SELECT * FROM users WHERE mobile= :mobile";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':mobile',$mobile,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id){

        $sql = "SELECT * FROM users WHERE id= :id";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }


    /* **************************************
     * Section 4
     * Ajax call Functions
     * ***************************************
     * */

    public function processNewActivationCode() :bool
    {
        $token = new Token();
        $this->activation_hash = $token->getHash();             // Saved in users table
        $this->activation_token = $token->getValue();  // To be send in email

        $sql = "UPDATE users SET activation_hash=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$this->activation_hash,$this->id]);

    }



    /**
     * @param $password
     * @return bool
     */
    public function updatePassword($password) :bool
    {
        $id = $this->id;
        $ph = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password_hash=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$ph,$id]);
    }


    /**
     * @param $time
     * @return bool
     */
    public function updateLastUserActivity($time){

        $id = $this->id;
        $sql = "UPDATE users SET last_activity=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$time,$id]);


    }


    /**
     * @param $userId
     * @param $mobile
     * @return bool
     */
    public static function updateMobile($userId, $mobile){

        $query = "UPDATE users SET mobile=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);
        return $stmt->execute([$mobile,$userId]);
    }


    /* **************************************
     *  Section 5
     *  Administrative Functions
     * ***************************************
     * */

    public static function newMembers(){

        $sql = "SELECT * FROM users WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY id desc";
        $pdo = Model::getDB();

        $stmt = $pdo->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * @return int
     */
    public static function getPaidUserCount(){

        $sql = "SELECT * FROM users WHERE is_paid=1";

        $pdo = Model::getDB();
        $stmt = $pdo->query($sql);
        $stmt->execute();
        return $stmt->rowCount();

    }

    /**
     * Admin Recent Paid Members
     *
     * @return array
     */
    public static function recentPaidMembers(){

        $sql = "SELECT * FROM users WHERE is_paid=1 ORDER BY id desc LIMIT 10";
        $pdo = Model::getDB();

        $stmt = $pdo->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /* **************************************
    *  Section 6
    *  Referral Program Functions
    * ***************************************
    * */




    /* **************************************
     *  Section 7
     *  Password Reset Functions
     * ***************************************
     * */

    /**
     * Send password reset instructions to the user specified
     *
     * @param string $email The email address
     *
     * @return void
     */
    public static function sendPasswordReset($email)
    {
        $user = static::findByEmail($email);

        if ($user) {

            if ($user->startPasswordReset()) {

                $user->sendPasswordResetEmail();

            }
        }
    }

    /**
     * Start the password reset process by generating a new token and expiry
     *
     * @return bool
     */
    protected function startPasswordReset()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getValue();

        $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

        $sql = 'UPDATE users
                SET password_reset_hash = :token_hash,
                    password_reset_expires_at = :expires_at
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Send password reset instructions in an email to the user
     *
     * @return void
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    protected function sendPasswordResetEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

        $text = View::getTemplate('password/reset_email.txt', ['url' => $url]);
        $html = View::getTemplate('password/reset_email.html', ['url' => $url]);

        Mail::sendNew($this->email, 'Password reset', $text, $html);
    }

    /**
     * Find a user model by password reset token and expiry
     *
     * @param string $token Password reset token sent to user
     *
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */
    public static function findByPasswordReset($token)
    {
        $token = new Token($token);
        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM users
                WHERE password_reset_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {

            // Check password reset token hasn't expired
            if (strtotime($user->password_reset_expires_at) > time()) {

                return $user;
            }
        }
    }

    /**
     * Reset the password
     *
     * @param string $password The new password
     *
     * @return boolean  True if the password was updated successfully, false otherwise
     */
    public function resetPassword($password)
    {
        $this->password = $password;

        $this->validateResetPassword();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
                    SET password_hash = :password_hash,
                        password_reset_hash = NULL,
                        password_reset_expires_at = NULL
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validation for new password
     */
    protected function validateResetPassword(){

        if (strlen($this->password) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }

    }

    /* *********************************
     * Section 8
     * Account Activation Functions
     * **********************************
     * */

    /**
     * Send an email to the user containing the activation link
     *
     * @return void
     */
    public function sendActivationEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/register/activate/' . $this->activation_token;

        $text = View::getTemplate('register/activation_email.txt', ['url' => $url]);
        $html = View::getTemplate('register/activation_email.html', ['url' => $url]);

        Mail::sendNew($this->email, 'Account activation', $text, $html);
        // TODO with mail exception
    }

    /**
     * Activate the user account with the specified activation token
     *
     * @param string $value Activation token from the URL
     *
     * @return bool
     */
    public static function activate($value)
    {
        $token = new Token($value);
        $hashed_token = $token->getHash();

        $sql = 'UPDATE users SET is_active = 1, ev = 1, activation_hash = null WHERE activation_hash = ?';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        //$stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);
        $stmt->execute([$hashed_token]);
        /*var_dump($stmt->rowCount());
        exit();*/
        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }




    /* *********************************
     *  Section 9
     *  Advance Search
     * **********************************
     * */

    public static function verifyUser($userId){

        $sql = "UPDATE users SET is_verified=1 WHERE id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    /**
     * On Successful payment update user paid status
     * @param $userId
     * @return bool
     */
    public static function updateUserPaidStatus($userId){

        $sql = "UPDATE users SET is_paid=1 WHERE id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);

    }


    public static function timeQuery($t){

        $query = "SELECT * FROM users WHERE created_at > ?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($query);
        $stmt->execute([$t]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }


    /* **************************************
     *  Section
     *  Update User Functions
     * ***************************************
     * */

    /**
     * @param $data
     * @return bool
     */
    public function saveUserProfile($data){

        foreach ($data as $key => $value){
            $this->$key=$value;
        }

        $this->name = $this->first_name.' '.$this->last_name;
        $this->dob = $this->year.'-'.$this->month.'-'.$this->day;
        $this->country_id = 77;

        $sql = "UPDATE users SET 
                first_name= :fName,
                last_name= :lName,
                name= :name, 
                dob= :dob,
                religion_id= :religion,
                community_id= :community,
                education_id= :education,
                occupation_id= :occupation,
                marital_id= :marital,
                manglik_id= :manglik,
                height_id= :height,
                country_id= :country
                WHERE id= :id";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([
            ':fName'=>$this->first_name,
            ':lName'=>$this->last_name,
            ':name'=>$this->name,
            ':dob'=>$this->dob,
            ':religion'=>$this->religion_id,
            ':community'=>$this->community_id,
            ':education'=>$this->education_id,
            ':occupation'=>$this->occupation_id,
            ':marital'=>$this->marital_id,
            ':manglik'=>$this->manglik_id,
            ':height'=>$this->height_id,
            ':country'=>$this->country_id,
            ':id'=>$this->id
        ]);
    }

    public static function getFiveRandomProfiles($gender){

        $sql = "SELECT id from users WHERE gender!=?";
        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$gender]);

        $user_ids = array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

        $list =  array_rand($user_ids,3);
        $returnArr=array();
        foreach ($list as $k=>$v){
            $returnArr[]=$user_ids[$v];
        }
        return $returnArr;

    }

    public function updateOtp($otp){

        $this->otp = $otp;
        $sql = "UPDATE users SET otp=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->otp,
            $this->id
        ]);
    }

    public function verifyMobile(){

        $sql = "UPDATE users SET mv=?,otp=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([1,Null,$this->id]);
    }



    public function groupsNew(){

        $sql = "SELECT g.name, sub.id, sub.name FROM user_group as ug
                JOIN groups AS g ON g.id=ug.group_id 
                JOIN subjects AS sub ON sub.group_id=g.id
                WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$this->id]);
        $courses = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

        $arr = array();
        $newKey = 0;
        foreach ($courses as $k=>$v){

            //echo $k;
            if(!in_array($k,$arr)){
                $newKey++;
                $arr[$newKey]['call']=$k;
                $arr[$newKey]['subjects']=$v;
            }
        }
        return $arr;
    }

    public function groups(){

        $sql = "SELECT g.id, g.name, g.descr FROM user_group as ug
                JOIN groups AS g ON g.id=ug.group_id WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function orders(){

        $sql = "SELECT * FROM  orders WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function subscribedGroups(){

        $sql = "SELECT group_id FROM user_group WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function liveSearch($start, $limit){

        $query = "SELECT * FROM users";

        if($_POST['query'] != ''){
            $query .= '
            WHERE first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR email LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }

        $query .= ' ORDER BY id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    public static function liveSearchCount(){

        $query = "SELECT * FROM users";

        if($_POST['query'] != ''){
            $query .= '
            WHERE first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR email LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();


    }

    public static function userRecords($arr){

        $query = '';
        $output = array();

        $query .= "SELECT * FROM users ";

        if(isset($arr["search"]["value"]))
        {
            $query .= 'WHERE first_name LIKE "%'.$arr["search"]["value"].'%" ';
            $query .= 'OR last_name LIKE "%'.$arr["search"]["value"].'%" ';
        }
        if(isset($arr["order"]))
        {
            $query .= 'ORDER BY '.$arr['order']['0']['column'].' '.$arr['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY id DESC ';
        }
        if($arr["length"] != -1)
        {
            $query .= 'LIMIT ' . $arr['start'] . ', ' . $arr['length'];
        }

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();



        /*$data = array();
        $filtered_rows = $statement->rowCount();*/

    }

    public static function userRecordsCount(){

        $query = "SELECT * FROM users ";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();

    }

    public static function insertUserAjaxRecord($arr){

        if(isset($arr["operation"]))
        {
            // Insert Record
            if($arr["operation"] == "Add")
            {
                $query = "INSERT INTO users (first_name, last_name) 
                   VALUES (:first_name, :last_name)
                  ";

                $pdo=Model::getDB();
                $stmt=$pdo->prepare($query);
                return $result = $stmt->execute([
                    ':first_name' => $arr["first_name"],
                    ':last_name' => $arr["last_name"]
                ]);
            }


            // Update Record
            if($_POST["operation"] == "Edit")
            {

                $query = "UPDATE users 
                   SET first_name = :first_name, last_name = :last_name  
                   WHERE id = :id
                   ";
                $pdo=Model::getDB();
                $stmt=$pdo->prepare($query);
                return $result = $stmt->execute([
                    ':first_name' => $arr["first_name"],
                    ':last_name' => $arr["last_name"],
                    ':id'   => $arr["user_id"]
                ]);

            }

        }

    }

    public static function fetchSingleUserAjaxRecord($arr){

        if(isset($arr["user_id"]))
        {

            $query = "SELECT * FROM users 
                      WHERE id = '".$arr["user_id"]."' 
                      LIMIT 1";
            $pdo=Model::getDB();
            $stmt=$pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();



        }
    }

    public static function deleteUserAjaxRecord($arr){

        if(isset($arr["user_id"]))
        {

            $sql = "DELETE FROM users WHERE id = :id";

            $pdo=Model::getDB();
            $stmt=$pdo->prepare($sql);
            return $stmt->execute(
                array(
                    ':id' => $arr["user_id"]
                )
            );

        }
    }





}
