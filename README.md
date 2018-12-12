# Purge fastly

Craft 3 cms plugin to work with [fastly service](https://www.fastly.com/)

It adds Purge Fastly tab with Surrogate keys field to every entry type on plugin install

### Setup the plugin:    
- connect to docker container(if needed):
```
docker exec -it %container_name% /bin/bash
```
- add repository:
```
composer config repositories.purge-fastly vcs https://in.thewardro.be/io/interactive/purge-fastly-plugin.git
```
- add gitlab creds to composer(if composer auth.json is not exists, otherwise update auth.json if needed):
```
env COMPOSER_AUTH='{"http-basic":{"in.thewardro.be":{"username":"%gitlab_username%","password":"%gitlab_password%"}}}'
```
- require package:
```
composer require belgiets/purge-fastly:dev-dev
``` 

### Configure the plugin:
Configure [API token](https://docs.fastly.com/api/auth#tokens) and Fastly services ids on plugin's settings page

You need to add that line to your entry template at the top to create relationships between keys and objects [API doc](https://docs.fastly.com/guides/purging/getting-started-with-surrogate-keys#creating-relationships-between-keys-and-objects)

```
{% header "Surrogate-Key: " ~ entry.surrogateKeys %}
```

After entry save/edit it'll send purge request to fastly service (if surrogate keys configured for that entry)
