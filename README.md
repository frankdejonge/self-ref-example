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

The relationships are as followed:
```
[[1,2], [2,3], [2,4], [1,4], [4,5], [4,7]]
```

So, getting relationship suggestions for Person 7 should include every relation
except Person 4 (already a connection) and Person 6 (no relation).