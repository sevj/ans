# Adimeo Notifications Bundle

Ce bundle permet de configurer et d'envoyer des notifications via des évènements en utilisant le composant messenger et mercure.

## Installation
* composer install adimeo/notifications-bundle
* ajouter `Adimeo\Notifications\ANSBundle::class => ['all' => true],` dans `bundles.php
* ajouter les variables d'environnement suivantes :
`
MERCURE_PUBLISH_URL=http://localhost:3000/.well-known/mercure
MERCURE_JWT_TOKEN=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOltdfX0.Oo0yg7y4yMa1vr_bziltxuTCqb8JVHKxp-f_FwwOim0
MESSENGER_TRANSPORT_DSN_MAILER=amqp://guest:guest@127.0.0.1:5672/%2f/mails
MESSENGER_TRANSPORT_DSN=amqp://guest:guest@127.0.0.1:5672/%2f/default
`

## Utilisation
- Créez la(es) entité(s) de notification qui implémentent l'interface `Adimeo\Notifications\NotificationInterface` et étendent la classe abstraite `Adimeo\Notifications\AbstractNotification`.
`
/**
 * Class UserNotification
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_notifications")
 */
class UserNotification extends AbstractNotification implements NotificationInterface
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    public static function getTargetedEntity(): string
    {
        return User::class;
    }
}
`
- Implémentez la méthode `getTargetedEntity()` pour qu'elle retourne le fqcn vers l'objet récipient de la notification (user, admin etc).
- Pensez à bien mettre les docblocks doctrine
- `php bin/console d:s:u --force` pour initialiser votre table de notifications 

- Levez vos évènements en utilisant l'évènement `Adimeo\Notifications\Event\NotificationEvent` comme suis :
`
$this->dispatcher->dispatch(new NotificationEvent(
    (new UserNotification($user, $payload))
));
`
$user représente l'entité utilisateur (ou admin, ou autre) lié à la notification
$payload est un array contenant les payload de la notification (enregistré en json en base)

- Pour récupérer les notifications d'un utilisateur, utilisez la méthode `Adimeo\Services\NotificationManager->fetchForOneUser()` :
`
$notifications = $this->notificationManager->fetchForOneUser(
    $fqcn,
    $id,
    $page,
    $limit,
    $orderBy,
    $filters
);
`

$fqcn : le fqcn de l'entité de notification, dans notre exemple `UserNotification::class`
$id : l'id de l'utilisateur
$page : la page à récupérer
$limit : le nombre de notifications
$orderBy : un tableau sous le modèle doctrine pour l'ordre, par défaut date décroissante de création
$filters : un tableau de filtres sous le modèle doctrine 

