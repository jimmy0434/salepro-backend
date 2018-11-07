#Indevco MasterPak

Indevco masterpak is application for salesman.

Codendot, will provide a solution with a back-end that controls Windows app, iOS app and android app using a unique dashboard. Solution will allow (ok) salesman to find all company resources while visiting a client or a new lead. Also he will be able to add new competitors using dynamic forms created from the backend. There will be 3 main sections:

 - Content Hub
 - Market Intelligence
 - Competitor Profiles

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and restful
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
restful
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
