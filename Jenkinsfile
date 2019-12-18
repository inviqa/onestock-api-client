pipeline {
    agent {
        docker {
            image 'my127/php:7.2-fpm-stretch-console'
        }
    }
    stages {
        stage('Install') {
            steps { 
                sh 'rm -f composer.lock' 
                sh 'composer install'
            }
        }

        stage('Test') {
            parallel {
                stage('unit')       { steps { sh 'composer phpspec' } }
                stage('acceptance') { steps { sh 'composer behat' } }
                stage('static-analysis') { steps { sh 'composer phpstan' } }
                stage('standards')  { steps { sh 'PHP_CS_FIXER_FUTURE_MODE=1 bin/php-cs-fixer --diff --using-cache=no --dry-run -v fix' } }
            }
        }
    }
}
