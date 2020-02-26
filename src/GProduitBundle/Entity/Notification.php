<?php


namespace GProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * Notifications
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="GProduitBundle\Repository\NotificationRepository")
 */
class Notification extends BaseNotification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }


}