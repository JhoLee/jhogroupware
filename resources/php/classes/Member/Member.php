<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-26
 * Time: 오전 11:38
 */

namespace Member;


class Member
{

    protected $id = '-1';
    protected $name = '_default';
    protected $team = '_default';
    public $mobile = '1541';
    public $birthday = '2018.01.26';
    protected $permission = -1;
    protected $rate = 'guest';

    /**
     * Member constructor.
     * @param $id : m_id
     * @param $name : m_name
     * @param $team : t_team
     * @param $mobile : m_mobile
     * @param $birthday : m_birthday
     * @param $permission : m_permission
     */

    public function __construct($id, $name, $team, $mobile, $birthday, $permission)
    {


        $this->id = $id;
        $this->name = $name;
        $this->team = $team;
        $this->mobile = $mobile;
        $this->birthday = $birthday;
        $this->permission = $permission;
        $this->setRate();

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeam(): string
    {
        return $this->team;
    }

    public function getPermission(): int
    {
        return $this->permission;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getAllInfo(): array
    {
        $info = array('id' => $this->id, 'name' => $this->name, 'team' => $this->team, 'permission' => $this->permission, 'rate' => $this->rate, 'mobile' => $this->mobile, 'birthday' => $this->birthday);

        return $info;
    }


    /**
     * @param
     * @return array {"id", "name", "team", "mobile", "birthday", "permission", "rate"}
     */
    public function getMemberInfo(): array
    {
        /* Get Members in same team */
        $member_info = array("id" => $this->getId(), "name" => $this->getName(), "team" => $this->getTeam(), "mobile" => $this->mobile, "birthday" => $this->birthday, "permission" => $this->getPermission(), "rate" => $this->_getRate($this->getPermission()));

        return $member_info;
    }

    /* */
    public function setRate()
    {
        switch ($this->getPermission()) {
            case 0:
                $this->rate = "guest";
                break;
            case 1:
                $this->rate = "member";
                break;
            case 2:
                $this->rate = "secondary manager";
                break;
            case 3:
                $this->rate = "leader";
                break;
            case 295:
                $this->rate = "secondary-manager";
                break;
            default:
                $this->rate = "unknown";
                break;

        }

    }


    static function _getRate($permission): string
    {
        /* Get name of rate by permission */
        switch ($permission) {
            case 0:
                $rate = "guest";
                break;
            case 1:
                $rate = "member";
                break;
            case 2:
                $rate = "secondary-manager";
                break;
            case 3:
                $rate = "leader";
                break;
            case 295:
                $rate = "secondary-manager";
                break;
            default:
                $rate = "unknown";
                break;


        }

        return $rate;
    }
}


