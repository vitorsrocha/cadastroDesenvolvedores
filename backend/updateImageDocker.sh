#!/bin/bash

CONTAINER_NAME="backend"
IMAGE_NAME="cadastro-desenvolvedores-backend "

if [ $(docker ps -q -f name=$CONTAINER_NAME) ]; then
    echo "Parando o container $CONTAINER_NAME..."
    docker stop $CONTAINER_NAME
fi

if [ $(docker ps -aq -f name=$CONTAINER_NAME) ]; then
    echo "Removendo o container $CONTAINER_NAME..."
    docker rm $CONTAINER_NAME
fi

if [ $(docker images -q $IMAGE_NAME) ]; then
    echo "Removendo a imagem $IMAGE_NAME..."
    docker rmi $IMAGE_NAME
fi

echo "Construindo uma nova imagem $IMAGE_NAME..."
docker build -t $IMAGE_NAME .

echo "Subindo um novo container com compose..."
docker compose up -d

echo "Container online"
docker ps