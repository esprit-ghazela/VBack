<?php


namespace GProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="GProduitBundle\Repository\NotificationRepository")
 */
class Notification extends BaseNotification implements \JsonSerializable
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