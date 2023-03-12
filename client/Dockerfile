# Stage 1: Compile and Build angular codebase

# Grab node!
FROM node:latest as build

# Make sure the server knows where to look for the app
WORKDIR /usr/local/app

# Copy out source code over to the nginx container.
COPY ./ /usr/local/app/

# Install all the dependencies
RUN npm install

# Make sure we build the application so that we're not running an old version (or worse, nothing!).
RUN npm run build


# Stage 2: Serve app with nginx server - we're going to use a second NGINX server here because keeping things modular is good fun.
# If they were on the same server, it would defeat the need for having a decoupled API - we could use something like blade or similar to achieve our goal of catching all the pokemon.

# We could use alpine as all we need is a basic level server to serve our app, keeping it small may be smart, however, for brevity I've just pulled the latest version of nginx.
FROM nginx:latest

# Drop our build output into the default location in NGINX so that it is served on port 8080 (see docker compose)
COPY --from=build /usr/local/app/dist/client /usr/share/nginx/html

# Expose port 80
EXPOSE 80
