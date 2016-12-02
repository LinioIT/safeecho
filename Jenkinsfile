application = env.JOB_NAME.substring(0, env.JOB_NAME.lastIndexOf("/"))
slackChannel = "#safeecho-api"

pipeline {
    agent any

    stages {
        stage("Install dependencies") {
            steps {
                parallel(
                    "PHP": {
                        sh "composer install"
                    }
                )
            }
        }

        stage("Run tests") {
            steps {
                parallel(
                    "php-cs-fixer": {
                        sh "php bin/php-cs-fixer fix --dry-run -vv"
                    },

                    "phpunit": {
                        sh "php bin/phpunit --log-junit junit_report.xml"
                    }
                )
            }
        }
    }

    post {
        always {
            junit "junit_report.xml"
        }
        success {
            slackNotify(application, "master", slackChannel, "good", "Build passed.")
        }
        failure {
            slackNotify(application, "master", slackChannel, "danger", "Build failed.")
        }
    }
}
