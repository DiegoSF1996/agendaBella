FROM node:22.5-alpine


WORKDIR /agendaBella

COPY package.json package-lock.json* ./

#RUN npm install

COPY . .

EXPOSE 19000 19001 19002 19006 8081

#CMD ["npx","expo", "start", "--tunnel"]
#CMD [ "npx", "expo", "start", "--port", "8081","--tunnel"]
CMD [ "npx", "expo", "start", "--port", "8081"]


