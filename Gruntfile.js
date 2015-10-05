module.exports = function ( grunt ) {
    var path = require( "path" );

    grunt.initConfig( {
        staticPath: path.resolve() + "/app/assets",
        outputPath: path.resolve() + "/web/assets",
        nodeModulesPath: path.resolve() + "/node_modules",

        copy: {
            assets: {
                expand: true,
                cwd: "<%=staticPath%>",
                src: [
                    "sass/**"
                ],
                dest: "<%=outputPath%>"
            },
            require: {
                expand: true,
                cwd: "<%=nodeModulesPath%>/requirejs",
                src: [
                    "require.js"
                ],
                dest: "<%=outputPath%>" + "/js"
            },
            bootstrap:{
                expand:true,
                cwd:"<%=nodeModulesPath%>/bootstrap/dist/css",
                src:[
                    "bootstrap.min.css"
                ],
                dest: "<%=outputPath%>" + "/css"
            }
        },
        sass: {
            dev: {
                options: {
                    style: "expanded"
                },
                files: [ {
                    expand: true,
                    cwd: "<%=staticPath%>/sass",
                    src: [ "*.scss" ],
                    dest: "<%=outputPath%>/css",
                    ext: ".css"
                } ]
            },
            dist: {
                options: {
                    style: "compressed"
                },
                files: {
                    "<%=staticPath%>/css/*.css": "<%=outputPath%>/sass/*.scss"
                }
            }
        },
        requirejs: {
            options: {
                baseUrl: "<%=staticPath%>/js",
                dir: "<%=outputPath%>/js",
                optimizeCss: false,
                paths: {
                    "handlebars": "<%=nodeModulesPath%>/handlebars/dist/handlebars.min",
                    "jquery": "<%=nodeModulesPath%>/jquery/dist/jquery.min"
                },
                modules: [ {
                    name: "TrainBooking"
                } ],
                generateSourceMaps: true,
                preserveLicenseComments: false
            },
            dev: {
                options: {
                    optimize: "none"
                }
            },
            dist: {
                options: {
                    optimize: "uglify2"
                }
            }
        },
        jshint: {
            options: {
                browser: true,
                curly: true,
                loopfunc: true,
                "-W002": true,
                "-W087": true,
                quotmark: true
            },
            all: {
                src: [ "Gruntfile.js", "<%=staticPath%>/assets/js/*.js" ]
            }
        },
        shell: {
            server: {
                command: "php -S 0.0.0.0:8000 -t web"
            }
        },
        watch: {
            sass: {
                files: [ "<%=staticPath%>/sass/**/*.scss" ],
                tasks: [ "sass:dev" ]
            },
            js: {
                files: [ "<%=staticPath%>/js/**.js", "Gruntfile.js"],
                tasks: [ "jshint", "requirejs:dev", "copy:require" ]
            }
        }
    } );

    grunt.loadNpmTasks( "grunt-sass" );
    grunt.loadNpmTasks( "grunt-contrib-watch" );
    grunt.loadNpmTasks( "grunt-contrib-jshint" );
    grunt.loadNpmTasks( "grunt-contrib-requirejs" );
    grunt.loadNpmTasks( "grunt-contrib-copy" );
    grunt.loadNpmTasks( "grunt-shell" );

    grunt.registerTask( "server", [ "shell:server" ] );
    grunt.registerTask( "default", [ "sass:dev", "jshint", "requirejs:dev", "copy:require", "copy:bootstrap"] );
    grunt.registerTask( "ci", [ "sass:dist", "jshint", "requirejs:dist", "copy:require", "copy:bootstrap"] );

};