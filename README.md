In order to make this project a bit funnier/useful for me, I decided to try [Phalcon](https://github.com/phalcon/cphalcon) framework.

Due to its limitations, it's not possible to use PHP8. Furthermore, it's not easy to install it on Alpine base Docker image.
I made it work by compiling sources inside the container and committing the resulting container as an image.
That's being said, there's no easy way to run it locally without that image. I may upload it publicly later if needed.

### Installation
Copy `.env.dev.dist` into `.env.dev` and configure XDebug if needed

After that running `docker-compose up -d` should be sufficient to run the app locally (at least on Linux)

### Tests
Run `./tests.sh` to run K6 tests 

