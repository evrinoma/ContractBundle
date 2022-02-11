    contractor:
        db_driver: orm модель данных
        factory_side: App\Code\Factory\SideFactory фабрика для создания объекта стороны, 
                 не достающие значения можно разрешить на уровне Mediator или переопределив фабрику 
        factory_contract: App\Code\Factory\ContractFactory фабрика для создания объекта контракта, 
                 не достающие значения можно разрешить на уровне Mediator или переопределив фабрику 
        entity_side: App\Code\Entity\Side сущность стороны
        entity_contract: App\Code\Entity\Contract сущность контракта
        constraints_contract: - включить валидацию по умолчанию для contract
        constraints_side: - включить валидацию по умолчанию для side
        dto_contract: App\Code\Dto\ContractDto класс dto с которым работает сущность contract
        dto_side: App\Code\Dto\SideDto класс dto с которым работает сущность side
        decorates:
          command_contract - декоратор команд контракта
          query_contract - декоратор запросов контракта
          command_side - декоратор команд связи контракта
          query_side - декоратор запросов связи контракта

# CQRS model

Actions в контроллере разбиты на две группы создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)

получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При преопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface Медиатор доступен только для Contract и Side сущностей

группы сериализации

          api_get_contract_hierarchy, api_post_contract_hierarchy, api_put_contract_hierarchy,
          api_get_contract_type, api_post_contract_type, api_put_contract_type,
          api_get_contract, api_post_contract, api_put_contract,
          api_get_side, api_post_side, api_put_side,

# Статусы:

release 1.0.1<br>
У контракта есть тип и есть иерархия - для классификации договора. Можно добавлять полезные данные либо слева либо справа к договору через специальное отношение side. например заказчики слева, а испольнители справа

сущность Contractor

    создание:
        код создан HTTP_CREATED 201
    обновление:
        код обновление HTTP_OK 200
    удаление:
        код удален HTTP_ACCEPTED 202
        при удалениисущность помечается как d
    получение:
        код(ы) найдены HTTP_OK 200
    ошибки:
        если код не найден ContractorNotFoundException возвращает HTTP_NOT_FOUND 404
        если код не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если код не прошел валидацию ContractorInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если код не может быть сохранен ContractorCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        если строна не может быть создана ContractorCannotBeCreatedException возвращает HTTP_BAD_REQUEST 400
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

сущность Side

    создание:
        строна создана HTTP_CREATED 201
    обновление:
        строна обновлена HTTP_OK 200
    удаление:
        строна удалена HTTP_ACCEPTED 202 
    получение:
        строна(ы) найдены HTTP_OK 200
    ошибки:
        если строна не найдена SideNotFoundException возвращает HTTP_NOT_FOUND 404
        если строна не уникалена UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если строна не прошла валидацию SideInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если строна не может быть сохранен SideCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        если строна не может быть создана SideCannotBeCreatedException возвращает HTTP_BAD_REQUEST 400
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

сущность Hierarchy

    создание:
        иерархия создан HTTP_CREATED 201
    обновление:
        иерархия обновление HTTP_OK 200
    удаление:
        иерархия удален HTTP_ACCEPTED 202
    получение:
        иерархия(и) найдены HTTP_OK 200
    ошибки:
        если иерархия не найдена HierarchyNotFoundException возвращает HTTP_NOT_FOUND 404
        если иерархия не уникалена UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если иерархия не прошла валидацию HierarchyInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если иерархия не может быть создана HierarchyCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        если иерархия не может быть сохранен HierarchyCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        если иерархия не может быть создана HierarchyCannotBeCreatedException возвращает HTTP_BAD_REQUEST 400
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

сущность Type

    создание:
        тип создан HTTP_CREATED 201
    обновление:
        тип обновление HTTP_OK 200
    удаление:
        тип удален HTTP_ACCEPTED 202
    получение:
        тип(ы) найдены HTTP_OK 200
    ошибки:
        если тип не найден TypeNotFoundException возвращает HTTP_NOT_FOUND 404
        если тип не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если тип не прошел валидацию TypeInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если тип не может быть сохранен TypeCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        если тип не может быть создан TypeCannotBeCreatedException возвращает HTTP_BAD_REQUEST 400
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сушности contract нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегестрировать сервис с этикеткой evrinoma.contract.constraint.property.contract

    evrinoma.contract.constraint.property.contract.custom:
        class: App\Contract\Constraint\Property\ContractCustom
        tags: [ 'evrinoma.contract.constraint.property.contract' ]

Для добавления проверки сушности contract нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Complex\ConstraintInterface; и зарегестрировать сервис с этикеткой evrinoma.contract.constraint.complex.contract

    evrinoma.contract.constraint.complex.side.custom:
        class: App\Contract\Constraint\Complex\ContractCustom
        tags: [ 'evrinoma.contract.constraint.complex.contract' ]

Для добавления проверки поля сушности side нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегестрировать сервис с этикеткой evrinoma.contract.constraint.property.side

    evrinoma.contract.constraint.property.side.custom:
        class: App\Contract\Constraint\Property\SideCustom
        tags: [ 'evrinoma.contract.constraint.property.side' ]

Для добавления проверки сушности side нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Complex\ConstraintInterface; и зарегестрировать сервис с этикеткой evrinoma.contract.constraint.complex.side

    evrinoma.contract.constraint.complex.side.custom:
        class: App\Contract\Constraint\Complex\SideCustom
        tags: [ 'evrinoma.contract.constraint.complex.side' ]

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/TypeApiControllerTest.php --filter "/::testPost( .*)?$/" 

