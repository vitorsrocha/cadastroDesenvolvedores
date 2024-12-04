#!/bin/bash

CONTAINER_NAME_BACKEND="backend"
CONTAINER_NAME_FRONTEND="frontend"
IMAGE_NAME_BACKEND="cadastro-desenvolvedores-backend"
IMAGE_NAME_FRONTEND="cadastro-desenvolvedores-frontend"


if [ $(docker ps -q -f name=$CONTAINER_NAME_BACKEND) ]; then
    echo "Parando o container $CONTAINER_NAME_BACKEND..."
    docker stop $CONTAINER_NAME_BACKEND
fi

if [ $(docker ps -aq -f name=$CONTAINER_NAME_BACKEND) ]; then
    echo "Removendo o container $CONTAINER_NAME_BACKEND..."
    docker rm $CONTAINER_NAME_BACKEND
fi

if [ $(docker images -q $IMAGE_NAME_BACKEND) ]; then
    echo "Removendo a imagem $IMAGE_NAME_BACKEND..."
    docker rmi $IMAGE_NAME_BACKEND
fi

#front

if [ $(docker ps -q -f name=$CONTAINER_NAME_FRONTEND) ]; then
    echo "Parando o container $CONTAINER_NAME_FRONTEND..."
    docker stop $CONTAINER_NAME_FRONTEND
fi

if [ $(docker ps -aq -f name=$CONTAINER_NAME_FRONTEND) ]; then
    echo "Removendo o container $CONTAINER_NAME_FRONTEND..."
    docker rm $CONTAINER_NAME_FRONTEND
fi

if [ $(docker images -q $IMAGE_NAME_FRONTEND) ]; then
    echo "Removendo a imagem $IMAGE_NAME_FRONTEND..."
    docker rmi $IMAGE_NAME_FRONTEND
fi

#-------

echo "Construindo uma nova imagem $IMAGE_NAME_BACKEND..."
cd backend
docker build -t $IMAGE_NAME_BACKEND .

echo "Construindo uma nova imagem $IMAGE_NAME_FRONTEND..."
cd ../frontend
docker build -t $IMAGE_NAME_FRONTEND .

echo "Subindo um novo container com compose..."
docker compose up -d

echo "Container online"
docker ps