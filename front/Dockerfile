FROM node:22.5-alpine
WORKDIR /app
EXPOSE 9000
LABEL maintainer="Diego F"
COPY package*.json ./
RUN npm install 
COPY . .
ENTRYPOINT [ "npx", "expo", "start", "--port", "9000" ]
