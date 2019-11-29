pipeline {
    agent {
        docker {
            image 'my127/php:7.2-fpm-stretch-console'
        }
    }
    stages {
        stage('Install') {
            steps { sh 'composer install' }
        }

        stage('Test') {
            parallel {
                stage('unit')       { steps { sh 'bin/phpspec run' } )
                stage('acceptance') { steps { sh 'bin/behat' } )
                stage('standards') { steps { sh 'sh 'PHP_CS_FIXER_FUTURE_MODE=1 bin/php-cs-fixer --diff --using-cache=no --dry-run -v fix'' } )
            }
        }
    }
}
