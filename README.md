# Purge fastly plugin for Craft CMS 3.x

Plugin adds specific field for setting fastly surrogate keys. If content has that keys it will be purged by every content save/edit action for every fastly service id(you can add ids on settings page).

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation
```
composer require lifechurch/purge-fastly
```

## Configuring Purge fastly

Configure [API token](https://docs.fastly.com/api/auth#tokens) and Fastly services ids on plugin's settings page

You need to add that line to your entry template at the top to create relationships between keys and objects [API doc](https://docs.fastly.com/guides/purging/getting-started-with-surrogate-keys#creating-relationships-between-keys-and-objects)

```
{% header "Surrogate-Key: " ~ entry.surrogateKeys %}
```

After entry save/edit it'll send purge request to fastly service (if surrogate keys configured for that entry)
