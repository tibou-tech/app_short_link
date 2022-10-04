## About App short link

App short link is a Laravel application that shortens links (like goo.gl or bit.ly)

## App Documentation
`App short link` is developed with `Laravel 9` and use `Laravel Breeze` for authentication

- Only a connected user can shorten links
- Anyone can register
- A user can delete links they have created
- A user can have a maximum of 5 links
- Links can be accessed by anyone, without obligation
connection (for redirection)
- The application is in English and French
- Links older than 24 hours will be removed
- The total number of links in the application does not exceed 20 links, in which case the oldest links are deleted
- We keep an access log of all the application URLs with the following data:

| Data for logging                                     |
| -----------------------------------------------------|
| `Le temps d'accès`                                   |
| `Le lien accédé`                                     |
| `L'identifiant de l'utilisateur s'il est connecté`   |
| `Adresse IP du client`                               |
| `Le pays`                                            |
| `Le User Agent du navigateur`                        |

### API For Get Country By IP Address


[Abstract api GeoLocation documentation](https://www.abstractapi.com/api/ip-geolocation-api)

`Api Key` for test: `78ec429731fd4c869d4ffbc59ba5ec8e`
