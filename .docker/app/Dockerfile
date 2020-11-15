FROM node:4.6

LABEL maintainer="nazar.10.17k@gmail.com"

RUN mkdir /naivechain
ADD ./app/package.json /naivechain/

RUN cd /naivechain && npm install

EXPOSE 3001
EXPOSE 6001

ENTRYPOINT cd /naivechain && npm install && PEERS=$PEERS npm start