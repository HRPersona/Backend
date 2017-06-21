<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Client\ClientInterface as ApiClient;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Core\Util\StringUtil;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="c_clients", indexes={@ORM\Index(name="client_search_idx", columns={"email"})})
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={
 *             "order.filter",
 *             "name.search",
 *             "email.search"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("email")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@bisnis.com>
 */
class Client implements ApiClient, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read", "write"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $email;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $apiKey;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var UserInterface
     */
    private $user;

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = StringUtil::uppercase($name);
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
     */
    public function setEmail(string $email)
    {
        $this->email = StringUtil::lowercase($email);
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ? UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;
    }
}
