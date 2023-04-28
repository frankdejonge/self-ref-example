## Example

setup:
```bash
docker compose up -d

 docker exec -it application bin/console doc:mig:mig --no-interaction
```

To seed the relationships, his this endpoint:

```bash
curl http://localhost:8080
```

Check the ID of Person 7 in a database UI of choice, and hit the following URL

```bash
http://localhost:8080/recommend-friends-for/{uuid}/
```