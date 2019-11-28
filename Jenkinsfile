pipeline {
    agent {
        docker {
            label "my127ws"
            image 'php:7.2'
        }
    }
    stages {
        stage('Prepare') {
            steps {
                sh 'composer install'
            }
        }
	stage('Test') {
            steps {
                sh 'vendor/bin/phpspec run'
            }
        }
    }
}
