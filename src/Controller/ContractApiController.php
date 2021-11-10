<?php

namespace Evrinoma\ContractBundle\Controller;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractInvalidException;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Manager\Contract\CommandManagerInterface;
use Evrinoma\ContractBundle\Manager\Contract\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class ContractApiController extends AbstractApiController implements ApiControllerInterface
{

    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var string
     */
    private string $dtoClass;

    /**
     * ApiController constructor.
     *
     * @param SerializerInterface     $serializer
     * @param RequestStack            $requestStack
     * @param FactoryDtoInterface     $factoryDto
     * @param CommandManagerInterface $commandManager
     * @param QueryManagerInterface   $queryManager
     * @param string                  $dtoClass
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
        $this->dtoClass       = $dtoClass;
    }

    /**
     * @Rest\Post("/api/contract/create", options={"expose"=true}, name="api_create_contract")
     * @OA\Post(
     *     tags={"contract"},
     *     description="the method perform create contract",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\ContractApiDto",
     *                  "name":"Договор №154/18-СП от 23.10.2018г."
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\ContractApiDto"),
     *               @OA\Property(property="name",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create contract")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var ContractApiDtoInterface $contractApiDto */
        $contractApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;
        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($contractApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($contractApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_contract')->json(['message' => 'Create contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/contract/save", options={"expose"=true}, name="api_save_contract")
     * @OA\Put(
     *     tags={"contract"},
     *     description="the method perform save contract for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\ContractApiDto",
     *                  "id":"3",
     *                  "active": "b",
     *                  "name":"Договор генерального подряда"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\ContractApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="active",type="string"),
     *               @OA\Property(property="name",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save contract")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var ContractApiDtoInterface $contractApiDto */
        $contractApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        try {
            if ($contractApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($contractApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($contractApiDto);
                    }
                );
            } else {
                throw new ContractInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_contract')->json(['message' => 'Save contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/contract/delete", options={"expose"=true}, name="api_delete_contract")
     * @OA\Delete(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\ContractApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Delete contracts")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var ContractApiDtoInterface $contractApiDto */
        $contractApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($contractApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($contractApiDto, $commandManager, &$json) {
                        $commandManager->delete($contractApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new ContractInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    public function criteriaAction(): JsonResponse
    {
        /** @var ContractApiDtoInterface $contractApiDto */
        $contractApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($contractApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_contract')->json(['message' => 'Get contracts', 'data' => $json], $this->queryManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/contract", options={"expose"=true}, name="api_contract")
     * @OA\Get(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\ContractApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return contracts")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var ContractApiDtoInterface $contractApiDto */
        $contractApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($contractApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_contract')->json(['message' => 'Get contracts', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof ContractCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof ContractNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof ContractInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
}