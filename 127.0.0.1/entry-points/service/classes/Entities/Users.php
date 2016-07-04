<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="Users", uniqueConstraints={@ORM\UniqueConstraint(name="account", columns={"account"})})
 * @ORM\Entity(repositoryClass="Repositories\Users")
 */
class Users extends \Lib\ORM\Entity
{
    /**
     * @var string
     *
     * @ORM\Column(name="account", type="string", length=20, nullable=false)
     */
    protected $account;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", length=65535, nullable=false)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="text", length=65535, nullable=false)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", length=65535, nullable=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="text", length=65535, nullable=true)
     */
    protected $token;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5, nullable=false)
     */
    protected $locale;



    /**
     * Set account
     *
     * @param string $account
     *
     * @return Users
     */
    public function setAccount(
        $account
    )
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Init account
     *
     * @param string $account
     *
     * @return Users
     */
    public function initAccount(
        $account
    )
    {
        if ($this->account !== null) {
            return $this;
        }
    
        if (is_callable($account)) {
            return $this->setAccount($account());
        }
    
        return $this->setAccount($account);
    }

    /**
     * Get account
     *
     * @param $account = null
     *
     * @return string
     */
    public function getAccount(
        $account = null
    )
    {
        if ($this->account !== null) {
            return $this->account;
        }
    
        if (is_callable($account)) {
            return $account();
        }
    
        return $account;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Users
     */
    public function setType(
        $type
    )
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Init type
     *
     * @param string $type
     *
     * @return Users
     */
    public function initType(
        $type
    )
    {
        if ($this->type !== null) {
            return $this;
        }
    
        if (is_callable($type)) {
            return $this->setType($type());
        }
    
        return $this->setType($type);
    }

    /**
     * Get type
     *
     * @param $type = null
     *
     * @return string
     */
    public function getType(
        $type = null
    )
    {
        if ($this->type !== null) {
            return $this->type;
        }
    
        if (is_callable($type)) {
            return $type();
        }
    
        return $type;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail(
        $email
    )
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Init email
     *
     * @param string $email
     *
     * @return Users
     */
    public function initEmail(
        $email
    )
    {
        if ($this->email !== null) {
            return $this;
        }
    
        if (is_callable($email)) {
            return $this->setEmail($email());
        }
    
        return $this->setEmail($email);
    }

    /**
     * Get email
     *
     * @param $email = null
     *
     * @return string
     */
    public function getEmail(
        $email = null
    )
    {
        if ($this->email !== null) {
            return $this->email;
        }
    
        if (is_callable($email)) {
            return $email();
        }
    
        return $email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword(
        $password
    )
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Init password
     *
     * @param string $password
     *
     * @return Users
     */
    public function initPassword(
        $password
    )
    {
        if ($this->password !== null) {
            return $this;
        }
    
        if (is_callable($password)) {
            return $this->setPassword($password());
        }
    
        return $this->setPassword($password);
    }

    /**
     * Get password
     *
     * @param $password = null
     *
     * @return null
     */
    public function getPassword(
        $password = null
    )
    {
        return $password;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Users
     */
    public function setToken(
        $token
    )
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Init token
     *
     * @param string $token
     *
     * @return Users
     */
    public function initToken(
        $token
    )
    {
        if ($this->token !== null) {
            return $this;
        }
    
        if (is_callable($token)) {
            return $this->setToken($token());
        }
    
        return $this->setToken($token);
    }

    /**
     * Get token
     *
     * @param $token = null
     *
     * @return null
     */
    public function getToken(
        $token = null
    )
    {
        return $token;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return Users
     */
    public function setLocale(
        $locale
    )
    {
        $this->locale = $locale;
    
        return $this;
    }

    /**
     * Init locale
     *
     * @param string $locale
     *
     * @return Users
     */
    public function initLocale(
        $locale
    )
    {
        if ($this->locale !== null) {
            return $this;
        }
    
        if (is_callable($locale)) {
            return $this->setLocale($locale());
        }
    
        return $this->setLocale($locale);
    }

    /**
     * Get locale
     *
     * @param $locale = null
     *
     * @return string
     */
    public function getLocale(
        $locale = null
    )
    {
        if ($this->locale !== null) {
            return $this->locale;
        }
    
        if (is_callable($locale)) {
            return $locale();
        }
    
        return $locale;
    }

    public function isPassword(
        string $password
    )
    {
        return password_verify($password, $this->password);
    }
}