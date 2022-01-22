<?php

namespace Evrinoma\ContractBundle\Controller;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\ContractBundle\Dto\HierarchyApiDto;
use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyInvalidException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Manager\Hierarchy\CommandManagerInterface;
use Evrinoma\ContractBundle\Manager\Hierarchy\QueryManagerInterface;
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

final class HierarchyApiController extends AbstractApiController implements ApiControllerInterface
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
    private string $dtoClass = HierarchyApiDto::class;

    /**
     * ApiController constructor.
     *
     * @param SerializerInterface     $serializer
     * @param RequestStack            $requestStack
     * @param FactoryDtoInterface     $factoryDto
     * @param CommandManagerInterface $commandManager
     * @param QueryManagerInterface   $queryManager
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager
    ) {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
    }

    /**
     * @Rest\Post("/api/contract/hierarchy/create", options={"expose"=true}, name="api_contract_hierarchy_create")
     * @OA\Post(
     *     tags={"contract"},
     *     description="the method perform create hierarchy contract",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\HierarchyApiDto",
     *                  "name":"Договор №154/18-СП от 23.10.2018г."
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\HierarchyApiDto"),
     *               @OA\Property(property="name",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create hierarchy contract")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var HierarchyApiDtoInterface $hierarchyApiDto */
        $hierarchyApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;
        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($hierarchyApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($hierarchyApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_contract_hierarchy')->json(['message' => 'Create hierarchy contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/contract/hierarchy/save", options={"expose"=true}, name="api_contract_hierarchy_save")
     * @OA\Put(
     *     tags={"contract"},
     *     description="the method perform save hierarchy contract for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\HierarchyApiDto",
     *                  "id":"3",
     *                  "identity":"sub_expenses"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\HierarchyApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="identity",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save hierarchy contract")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var HierarchyApiDtoInterface $hierarchyApiDto */
        $hierarchyApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        try {
            if ($hierarchyApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($hierarchyApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($hierarchyApiDto);
                    }
                );
            } else {
                throw new HierarchyInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_contract_hierarchy')->json(['message' => 'Save hierarchy contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/contract/hierarchy/delete", options={"expose"=true}, name="api_contract_hierarchy_delete")
     * @OA\Delete(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\HierarchyApiDto",
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
     * @OA\Response(response=200,description="Delete hierarchy contracts")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var HierarchyApiDtoInterface $hierarchyApiDto */
        $hierarchyApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($hierarchyApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($hierarchyApiDto, $commandManager, &$json) {
                        $commandManager->delete($hierarchyApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new HierarchyInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete hierarchy contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/contract/hierarchy/criteria", options={"expose"=true}, name="api_contract_hierarchy_criteria")
     * @OA\Get(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\HierarchyApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="identity",
     *         in="query",
     *         name="identity",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return hierarchy contract")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var HierarchyApiDtoInterface $hierarchyApiDto */
        $hierarchyApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($hierarchyApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_contract_hierarchy')->json(['message' => 'Get hierarchy contracts', 'data' => $json], $this->queryManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/contract/hierarchy", options={"expose"=true}, name="api_contract_hierarchy")
     * @OA\Get(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\HierarchyApiDto",
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
     * @OA\Response(response=200,description="Return hierarchy contracts")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var HierarchyApiDtoInterface $hierarchyApiDto */
        $hierarchyApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($hierarchyApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_contract_hierarchy')->json(['message' => 'Get hierarchy contracts', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof HierarchyCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof HierarchyNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof HierarchyInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
}