pipeline {
    agent {
        docker {
            image 'my127/php:7.2-fpm-stretch-console'
        }
    }
    stages {
        stage('Test') {
            steps {
                sh 'composer install'
                sh 'bin/phpspec run'
                sh 'bin/behat'
            }
        }
    }
}
