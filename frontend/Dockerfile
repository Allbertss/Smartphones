FROM node:24.0.1

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install --platform=linux --arch=x64

COPY . .

CMD ["npm", "run", "dev"]