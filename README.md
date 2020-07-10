# gravityforms-salesforce-api
This API converts WordPress gravity forms submissions into SalesForce leads. Might be useful for Headless WordPress sites.

Some clarifications
- The plugin provides many endpoints that can be reached through external services to check the working status.
- The plugin uses env variables for some settings. So it's not clone and run on WordPress, it will require some configuration.
- Salesforce fields must be manually configured on gsa-api.php on createNewGFEntry(), so you have them properly saved on Gravity Forms too.
- Also Salesforce fields must be manually configured on gsa-api.php, prepareFields().
- Finally Salesforce fields must be configured on inc/gsa-sf-api/gsa-sf-api-services.php, method getAllLeads()

Unit Tests
- Some unit tests are provided but, a lot of manual configuration might be required for the Unit Tests to work.