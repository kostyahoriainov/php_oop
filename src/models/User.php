<?php


namespace Models;

use \PDO;
use \Resourse\Request;

class User extends Model
{
    private $id;

    private $email;

    private $password;

    private $first_name;

    private $last_name;

    private $created_at;


    private function __construct(int $id, string $email, string $password, string $first_name, string $last_name, string $created_at)
    {
        $this->setId($id);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setCreatedAt($created_at);
    }

    /**
     * @param Request $request
     * @return array
     */
    public static function find(Request $request): array
    {
        $request_params = $request->getRequestParams();

        $result = self::isUserExist($request_params);

        if(empty($result[0])) {
            return [
                'result' => false,
                'message' => 'No such user'
                ];
        }

        $params = [
            ':email' => trim($request_params['email']),
            ':password' => md5(trim($request_params['password']))
        ];
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";

        $connection = Database::getConnection();

        $user = self::fetchData($connection, $sql, $params);

        if (empty($user)) {
            return [
                'result' => false,
                'message' => 'Wrong email or password'
            ];
        }

        $user = $user[0];

        $result = [
            'result' => true,
            'user' => new self($user['id'], $user['email'], $user['password'], $user['first_name'], $user['last_name'], $user['created_at'])
        ];

        return $result;
    }

    public static function create(Request $request)
    {
        $request_params = $request->getRequestParams();

        $result = self::isUserExist($request_params);

        if(!empty($result[0])) {
            return [
                'result' => false,
                'message' => 'This email is already taken'
            ];
        }

        $params = [
            ':email' => trim($request_params['email']),
            ':password' => md5(trim($request_params['password'])),
            ':first_name' => trim($request_params['first_name']),
            ':last_name' => trim($request_params['last_name'])
        ];

        $sql = "INSERT INTO users (email, password, first_name, last_name) 
                VALUES (:email, :password, :first_name, :last_name)";

        $connection = Database::getConnection();

        self::fetchData($connection, $sql, $params);

        return [
            'result' => true
        ];
    }

    /**
     * @param array $request_params
     * @return array
     */
    private static function isUserExist(array $request_params): array
    {
        $params = [
            ':email' => trim($request_params['email'])
        ];

        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";

        $connection = Database::getConnection();

        return self::fetchData($connection, $sql, $params, PDO::FETCH_COLUMN);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    private function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    private function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    private function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return User
     */
    private function setFirstName(string $first_name): User
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    private function setLastName(string $last_name): User
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return User
     */
    private function setCreatedAt(string $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }
}