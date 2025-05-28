pipeline {
    agent any

    environment {
        IMAGE_NAME            = 'ppob-app'
        DOCKERFILE            = 'Dockerfile'
        CONTAINER_NAMES       = 'ppob-app'
        CONTAINER_TO_RESTARTS = 'app-ppob'
        
        // Development Environment
        DEV_REMOTE_USER        = ''
        DEV_SERVER_ADDRESS     = ''
        DEV_DEPLOYMENT_PATH    = ''
        DEV_SSH_CREDENTIALS_ID = ''

        // Staging Environment
        STAGE_REMOTE_USER        = ''
        STAGE_SERVER_ADDRESS     = ''
        STAGE_DEPLOYMENT_PATH    = ''
        STAGE_SSH_CREDENTIALS_ID = ''

        // Production Environment
        PROD_REMOTE_USER        = 'root'
        PROD_SERVER_ADDRESS     = '194.233.76.150'
        PROD_DEPLOYMENT_PATH    = '/root/platform'
        PROD_SSH_CREDENTIALS_ID = 'ssh-dev'
        
        MATTERMOST_ENDPOINT = 'https://team.nusatech.id/hooks/gdr9ikp64pdejqxb6zd6irfjrw'
        MATTERMOST_CHANNEL  = 'nusatech'
        MATTERMOST_ICON     = 'https://www.jenkins.io/images/logos/baturro/baturro.png'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Gather Information') {
            steps {
                script {
                    env.GIT_COMMIT   = sh(script: "git rev-parse HEAD", returnStdout: true).trim()
                    env.GIT_AUTHOR   = sh(script: "git log -1 --pretty=format:'%an'", returnStdout: true).trim()
                    env.GIT_MESSAGE  = sh(script: "git log -1 --pretty=format:'%s'", returnStdout: true).trim()
                }
            }
        }

        stage('Prepare Environment') {
            steps {
                script {
                    // Branch-based environment selection
                    if (env.BRANCH_NAME == 'main') {
                        env.IMAGE_TAG          = 'prod'
                        env.REMOTE_USER        = env.PROD_REMOTE_USER
                        env.SERVER_ADDRESS     = env.PROD_SERVER_ADDRESS
                        env.DEPLOYMENT_PATH    = env.PROD_DEPLOYMENT_PATH
                        env.SSH_CREDENTIALS_ID = env.PROD_SSH_CREDENTIALS_ID
                    } else if (env.BRANCH_NAME == 'stage') {
                        env.IMAGE_TAG          = 'stage'
                        env.REMOTE_USER        = env.STAGE_REMOTE_USER
                        env.SERVER_ADDRESS     = env.STAGE_SERVER_ADDRESS
                        env.DEPLOYMENT_PATH    = env.STAGE_DEPLOYMENT_PATH
                        env.SSH_CREDENTIALS_ID = env.STAGE_SSH_CREDENTIALS_ID
                    } else if (env.BRANCH_NAME == 'dev') {
                        env.IMAGE_TAG          = 'latest'
                        env.REMOTE_USER        = env.DEV_REMOTE_USER
                        env.SERVER_ADDRESS     = env.DEV_SERVER_ADDRESS
                        env.DEPLOYMENT_PATH    = env.DEV_DEPLOYMENT_PATH
                        env.SSH_CREDENTIALS_ID = env.DEV_SSH_CREDENTIALS_ID
                    } else {
                        error "Unsupported branch for deployment: ${env.BRANCH_NAME}"
                    }

                    // Construct full image name
                    withCredentials([
                        usernamePassword(
                            credentialsId: 'docker-devops', 
                            usernameVariable: 'DOCKERHUB_USER', 
                            passwordVariable: 'DOCKERHUB_PASS'
                        )
                    ]) {
                        env.IMAGE_FULL_NAME = "${DOCKERHUB_USER}/${env.IMAGE_NAME}:${env.IMAGE_TAG}"
                    }
                }
            }
        }

        stage('Docker Build and Push') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'docker-devops', 
                        usernameVariable: 'DOCKERHUB_USER', 
                        passwordVariable: 'DOCKERHUB_PASS'
                    )
                ]) {
                    script {
                        echo "Ensuring Docker Login..."
                        sh """
                            docker logout || true
                            echo "$DOCKERHUB_PASS" | docker login -u "$DOCKERHUB_USER" --password-stdin
                        """

                        def imageExists = sh(
                            script: "docker images -q ${env.IMAGE_FULL_NAME}", 
                            returnStdout: true
                        ).trim()

                        if (imageExists) {
                            echo "Removing existing image: ${env.IMAGE_FULL_NAME}"
                            sh "docker rmi -f ${env.IMAGE_FULL_NAME}"
                        }

                        echo "Building new image with tag ${env.IMAGE_TAG}..."
                        sh "docker build -t ${env.IMAGE_FULL_NAME} -f ${env.DOCKERFILE} ."

                        echo "Pushing image to Docker Hub..."
                        sh "docker push ${env.IMAGE_FULL_NAME}"
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    def deployEnv = (env.BRANCH_NAME == 'main') 
                        ? 'Production' 
                        : (env.BRANCH_NAME == 'stage') 
                            ? 'Staging' 
                            : 'Development'

                    echo "Deploying to ${deployEnv} Environment..."

                    // Optional confirmation for Production
                    if (env.BRANCH_NAME == 'main') {
                        input 'Approve for Production Deployment?'
                    }

                    deploy(env.REMOTE_USER, env.SERVER_ADDRESS, env.SSH_CREDENTIALS_ID)
                }
            }
        }

        stage('Check Container Status') {
            steps {
                script {
                    def checkEnv = (env.BRANCH_NAME == 'main') 
                        ? 'Production' 
                        : (env.BRANCH_NAME == 'stage') 
                            ? 'Staging' 
                            : 'Development'
                            
                    echo "Checking Container Status in ${checkEnv} Environment..."
                    checkRemoteContainerStatus(env.REMOTE_USER, env.SERVER_ADDRESS, env.SSH_CREDENTIALS_ID)
                }
            }
        }
    }

    post {
        success {
            notifyMattermost('#00FF00', ':white_check_mark:', 'Build Succeeded')
        }
        failure {
            notifyMattermost('#FF0000', ':x:', 'Build Failed')
        }
    }
}

/**
 * Deploy to remote server and recreate containers.
 */
def deploy(String remoteUser, String serverAddress, String sshCredentialsId) {
    def services = env.CONTAINER_TO_RESTARTS
        .split(',')
        .collect { it.trim() }
        .join(' ')

    sshagent(credentials: [sshCredentialsId]) {
        sh """
            ssh -o StrictHostKeyChecking=no ${remoteUser}@${serverAddress} '
                docker rmi -f ${env.IMAGE_FULL_NAME}
                cd ${env.DEPLOYMENT_PATH}
                docker-compose up -Vd ${services} --force-recreate
                docker image prune -f || true
            '
        """
    }
}

/**
 * Check the container status remotely.
 */
def checkRemoteContainerStatus(String remoteUser, String serverAddress, String sshCredentialsId) {
    env.CONTAINER_NAMES
        .split(',')
        .collect { it.trim() }
        .each { containerName ->
            sshagent(credentials: [sshCredentialsId]) {
                def result = sh(
                    script: """
                        ssh -o StrictHostKeyChecking=no ${remoteUser}@${serverAddress} '
                            docker container ls --filter "name=${containerName}" --format "{{.Status}}" | grep -oE "Up|Restarting|Down"
                        '
                    """,
                    returnStdout: true
                ).trim()

                checkContainerStatus(result, containerName)
            }
        }
}

/**
 * Provide a detailed container status check, matching the original logic.
 */
def checkContainerStatus(String result, String containerName) {
    if (result == "Up") {
        echo "${containerName} container is up and running on remote server"
    } else if (result == "Restarting") {
        error "${containerName} container is restarting on remote server, please check the logs and configuration"
    } else if (result == "Down") {
        error "${containerName} container is down on remote server, please check the logs and configuration"
    } else {
        error "${containerName} container not found or unexpected status on remote server, please check the logs and configuration"
    }
}

/**
 * Send Mattermost notification with environment details, matching original content.
 */
def notifyMattermost(String color, String icon, String status) {
    def envDisplay = (env.BRANCH_NAME == 'main') 
        ? 'Production'
        : (env.BRANCH_NAME == 'stage') 
            ? 'Staging'
            : (env.BRANCH_NAME == 'dev') 
                ? 'Development'
                : env.BRANCH_NAME

    mattermostSend(
        endpoint: env.MATTERMOST_ENDPOINT,
        channel: env.MATTERMOST_CHANNEL,
        color:   color,
        icon:    env.MATTERMOST_ICON,
        message: """
            **${status}** ${icon}
            **Job**: `${env.JOB_NAME} [${env.BUILD_NUMBER}]`
            **Branch**: `${env.BRANCH_NAME}`
            **Environment**: `${envDisplay}`
            **Commit**: `${env.GIT_COMMIT}`
            **Author**: `${env.GIT_AUTHOR}`
            **Message**: `${env.GIT_MESSAGE}`
            [View Build](${env.BUILD_URL})
            **Please check the Jenkins logs for more details.**
        """.trim()
    )
}