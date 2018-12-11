# Purge fastly

Craft 3 cms plugin to work with [fastly service](https://www.fastly.com/)

It adds Purge Fastly tab with Surrogate keys field to every entry type on plugin install 

Configure [API token](https://docs.fastly.com/api/auth#tokens) and Fastly services ids on plugin's settings page

You need to add that line to your entry template at the top to create relationships between keys and objects [API doc](https://docs.fastly.com/guides/purging/getting-started-with-surrogate-keys#creating-relationships-between-keys-and-objects)

```
{% header "Surrogate-Key: " ~ entry.surrogateKeys %}
```

After entry save/edit it'll send purge request to fastly service (if surrogate keys configured for that entry)
