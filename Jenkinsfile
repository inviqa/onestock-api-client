pipeline {
    agent {
        docker {
            label "my127ws"
            image 'my127/php:7.2-fpm-stretch-console'
        }
    }
    stages {
        stage('Test') {
            steps {
                sh 'composer install'
                sh 'vendor/bin/phpspec run'
            }
        }
    }
}
