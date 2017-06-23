<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActivityLoggerInterface;
use Persona\Hris\Core\Util\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ORM\Entity()
 * @ORM\Table(name="c_activities")
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={
 *             "order.filter",
 *             "client_name.search",
 *             "username.search",
 *             "path.search",
 *             "method.search",
 *             "created_at.filter",
 *             "updated_at.filter"
 *         }
 *     },
 *     collectionOperations={"get"={"method"="GET"}},
 *     itemOperations={"get"={"method"="GET"}}
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class UserActivity implements ActivityLoggerInterface
{
    use Timestampable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $clientName;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $path;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $method;

    /**
     * @ORM\Column(type="array")
     *
     * @var array
     */
    private $request;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $response;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $remark;

    /**
     * @ORM\Column(type="array", nullable=true)
     *
     * @var array
     */
    private $sourceTable;

    /**
     * @ORM\Column(type="array", nullable=true)
     *
     * @var array
     */
    private $identifier;

    /**
     * @ORM\Column(type="array", nullable=true)
     *
     * @var array
     */
    private $dataChanges;

    public function __construct()
    {
        $this->dataChanges = [];
    }

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
    public function getClientName(): string
    {
        return (string) $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName)
    {
        $this->clientName = $clientName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = StringUtil::lowercase($path);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->path;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = StringUtil::uppercase($method);
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->method ?: 'GET';
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = [
            'form' => $request->request->all(),
            'query' => $request->query->all(),
            'cookie' => $request->cookies->all(),
        ];
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->request;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response->getContent();
    }

    /**
     * @return string
     */
    public function getResponseContent(): string
    {
        return $this->response;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark)
    {
        $this->remark = $remark;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return (string) $this->remark;
    }

    /**
     * @param array $table
     */
    public function setSourceTable(array $table)
    {
        $this->sourceTable = $table;
    }

    /**
     * @return array
     */
    public function getSourceTable(): array
    {
        return $this->sourceTable;
    }

    /**
     * @param array $id
     */
    public function setIdentifier(array $id)
    {
        $this->identifier = $id;
    }

    /**
     * @return array)
     */
    public function getIdentifier(): array
    {
        return (array) $this->identifier;
    }

    /**
     * @param array $changes
     */
    public function setDataChanges(array $changes)
    {
        $this->dataChanges = $changes;
    }

    /**
     * @return array
     */
    public function getDataChanges(): array
    {
        return $this->dataChanges;
    }
}
