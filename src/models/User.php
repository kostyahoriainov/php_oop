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


    private function __construct(array $user)
    {
        $this->init($user);
    }

    private function init(array $user)
    {
        $this->setId($user['id']);
        $this->setEmail($user['email']);
        $this->setPassword($user['password']);
        $this->setFirstName($user['first_name']);
        $this->setLastName($user['last_name']);
        $this->setCreatedAt($user['created_at']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public static function find(Request $request): array
    {
        $request_params = $request->getRequestParams();

        $result = self::isUserExist($request_params);

        if(!$result) {
            return [
                'result' => false,
                'message' => \Controllers\User::ERROR_MESSAGES['user_not_exist']
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
                'message' => \Controllers\User::ERROR_MESSAGES['login_error']
            ];
        }

        $result = [
            'result' => true,
            'user' => new self($user[0])
        ];

        return $result;
    }

    public static function create(Request $request)
    {
        $request_params = $request->getRequestParams();

        $result = self::isUserExist($request_params);

        if($result) {
            return [
                'result' => false,
                'message' => \Controllers\User::ERROR_MESSAGES['email_is_taker']
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

        $result = self::insertData($connection, $sql, $params);

        return [
            'result' => $result
        ];
    }

    /**
     * @param array $request_params
     * @return array
     */
    private static function isUserExist(array $request_params): bool
    {
        $params = [
            ':email' => trim($request_params['email'])
        ];

        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";

        $connection = Database::getConnection();

        return (bool) self::fetchData($connection, $sql, $params, PDO::FETCH_COLUMN)[0];
    }

    public static function getById(int $id): User
    {
        $params = [
            ':id' => $id
        ];

        $sql = "SELECT * FROM users WHERE id = :id";

        $connection = Database::getConnection();

        $user = self::fetchData($connection, $sql, $params)[0];

        return new self($user);
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