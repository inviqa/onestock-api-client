pipeline {
    agent {
        label "my127ws"
        docker { image 'php:7.2' }
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
