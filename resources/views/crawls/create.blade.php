<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>

    <div class="container" id="app">

        <h1>Scan website</h1>

        <fieldset class="form-group">
            <label for="scrape-url">What is your url?</label>
            <div class="input-group">
                <input class="form-control" type="url" name="url" id="scrape-url" placeholder="Url of your website"
                       v-model="url" @click="selectAll">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" @click="scrapeUrl">
                        <i v-bind:class="[isScraping ? 'fa-spinner fa-spin' : 'fa-download', 'fa fa-fw']" aria-hidden="true"></i> Scan
                    </button>
                </span>
            </div>
        </fieldset>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                url: 'http://www.come-sit-stay.com/'
            },
            methods: {
                selectAll(event) {
                    event.target.select();
                }
            }
        })
    </script>
</body>
</html>