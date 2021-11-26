<?php

namespace Evrinoma\ContractBundle\Controller;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Side\SideInvalidException;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Manager\Side\CommandManagerInterface;
use Evrinoma\ContractBundle\Manager\Side\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Nelmio\ApiDocBundle\Annotation\Model;

final class SideApiController extends AbstractApiController implements ApiControllerInterface
{

//region SECTION: Fields
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
//endregion Fields

//region SECTION: Constructor
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
//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Post("/api/side/create", options={"expose"=true}, name="api_create_side")
     * @OA\Post(
     *     tags={"side"},
     *     description="the method perform create side",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\SideApiDto",
     *                  "name":"Договор №154/18-СП от 23.10.2018г.",
     *                  "type": {
     *                            "id":"2"
     *                       },
     *                  "hierarchy": {
     *                            "id":"1"
     *                       }
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\SideApiDto"),
     *               @OA\Property(property="name",type="string"),
     *               @OA\Property(property="type",type="object"),
     *               @OA\Property(property="hierarchy",type="object")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create side")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var SideApiDtoInterface $sideApiDto */
        $sideApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;
        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($sideApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($sideApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_side')->json(['message' => 'Create side', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/side/save", options={"expose"=true}, name="api_save_side")
     * @OA\Put(
     *     tags={"side"},
     *     description="the method perform save side for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\ContractBundle\Dto\SideApiDto",
     *                  "id":"3",
     *                  "active": "b",
     *                  "name":"Договор генерального подряда",
     *                  "type": {
     *                            "id":"2"
     *                   },
     *                  "hierarchy": {
     *                            "id":"1"
     *                       }
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\ContractBundle\Dto\SideApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="active",type="string"),
     *               @OA\Property(property="name",type="string"),
     *               @OA\Property(property="type",type="object"),
     *               @OA\Property(property="hierarchy",type="object")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save side")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var SideApiDtoInterface $sideApiDto */
        $sideApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            if ($sideApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($sideApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($sideApiDto);
                    }
                );
            } else {
                throw new SideInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_side')->json(['message' => 'Save side', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/side/delete", options={"expose"=true}, name="api_delete_side")
     * @OA\Delete(
     *     tags={"side"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\SideApiDto",
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
     * @OA\Response(response=200,description="Delete sides")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var SideApiDtoInterface $sideApiDto */
        $sideApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($sideApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($sideApiDto, $commandManager, &$json) {
                        $commandManager->delete($sideApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new SideInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete side', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/side/criteria", options={"expose"=true}, name="api_side_criteria")
     * @OA\Get(
     *     tags={"side"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\SideApiDto",
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
     *     @OA\Parameter(
     *         name="type[identity]",
     *         in="query",
     *         description="Type Identity",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\TypeChoiceType::class, options={"data":"identity"})
     *              ),
     *          ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="hierarchy[identity]",
     *         in="query",
     *         description="Hierarchy Identity",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\HierarchyChoiceType::class, options={"data":"identity"})
     *              ),
     *          ),
     *         style="form"
     *     )
     * )
     * @OA\Response(response=200,description="Return sides")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var SideApiDtoInterface $sideApiDto */
        $sideApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($sideApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_side')->json(['message' => 'Get sides', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/side", options={"expose"=true}, name="api_side")
     * @OA\Get(
     *     tags={"side"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\ContractBundle\Dto\SideApiDto",
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
     * @OA\Response(response=200,description="Return sides")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var SideApiDtoInterface $sideApiDto */
        $sideApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($sideApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_side')->json(['message' => 'Get sides', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof SideCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof SideNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof SideInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Getters/Setters
}