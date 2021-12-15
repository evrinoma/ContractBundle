<?php

namespace Evrinoma\ContractBundle\Controller;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\ContractBundle\Dto\TypeApiDto;
use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Type\TypeInvalidException;
use Evrinoma\ContractBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\ContractBundle\Manager\Type\CommandManagerInterface;
use Evrinoma\ContractBundle\Manager\Type\QueryManagerInterface;
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

final class TypeApiController extends AbstractApiController implements ApiControllerInterface
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
    private string $dtoClass = TypeApiDto::class;

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
     * @Rest\Post("/api/contract/type/create", options={"expose"=true}, name="api_contract_type_create")
     * @OA\Post(
     *     tags={"contract"},
     *     description="the method perform create type contract",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\TypeApiDto",
     *                  "identity":"contract"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\TypeApiDto"),
     *               @OA\Property(property="identity",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create type contract")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;
        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($typeApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($typeApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_contract_type')->json(['message' => 'Create type contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/contract/type/save", options={"expose"=true}, name="api_contract_type_save")
     * @OA\Put(
     *     tags={"contract"},
     *     description="the method perform save type contract for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\TypeApiDto",
     *                  "id":"2",
     *                  "identity":"add_agr"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\TypeApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="identity",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save type contract")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        try {
            if ($typeApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($typeApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($typeApiDto);
                    }
                );
            } else {
                throw new TypeInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_contract_type')->json(['message' => 'Save type contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/contract/type/delete", options={"expose"=true}, name="api_contract_type_delete")
     * @OA\Delete(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\TypeApiDto",
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
     * @OA\Response(response=200,description="Delete type contracts")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($typeApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($typeApiDto, $commandManager, &$json) {
                        $commandManager->delete($typeApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new TypeInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete type contract', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/contract/type/criteria", options={"expose"=true}, name="api_contract_type_criteria")
     * @OA\Get(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\TypeApiDto",
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
     * @OA\Response(response=200,description="Return contract types")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($typeApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_contract_type')->json(['message' => 'Get type contracts', 'data' => $json], $this->queryManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/contract/type", options={"expose"=true}, name="api_contract_type")
     * @OA\Get(
     *     tags={"contract"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\TypeApiDto",
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
     * @OA\Response(response=200,description="Return type contracts")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($typeApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_contract_type')->json(['message' => 'Get type contracts', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof TypeCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof TypeNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof TypeInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
}