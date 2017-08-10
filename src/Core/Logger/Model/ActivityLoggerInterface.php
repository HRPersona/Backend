<?php

namespace Persona\Hris\Core\Logger\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ActivityLoggerInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName);

    /**
     * @return string
     */
    public function getClientName(): string;

    /**
     * @param string $username
     */
    public function setUsername(string $username);

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @param string $path
     */
    public function setPath(string $path);

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request);

    /**
     * @return array
     */
    public function getRequestData(): array;

    /**
     * @param string $method
     */
    public function setMethod(string $method);

    /**
     * @return string
     */
    public function getRequestMethod(): string;

    /**
     * @param Response $response
     */
    public function setResponse(Response $response);

    /**
     * @return string
     */
    public function getResponseContent(): string;

    /**
     * @param string $remark
     */
    public function setRemark(string $remark);

    /**
     * @return string
     */
    public function getRemark(): string;

    /**
     * @param array $table
     */
    public function setSourceTable(array $table);

    /**
     * @return array
     */
    public function getSourceTable(): array;

    /**
     * @param array $id
     */
    public function setIdentifier(array $id);

    /**
     * @return array
     */
    public function getIdentifier(): array;

    /**
     * @param array $changes
     */
    public function setDataChanges(array $changes);

    /**
     * @return array
     */
    public function getDataChanges(): array;
}
