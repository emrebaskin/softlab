<!doctype html>
<html class="h-100" lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <title>Hello, world!</title>
</head>
<body class="h-100">


<div id="app" class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-md-3 col-lg-2 bg-dark h-100">
            <ul class="list-group list-group-flush my-3">
                <li v-for="category in categories" class="list-group-item" @click="getVenues(category.id)">@{{
                    category.name }}
                </li>
            </ul>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="row">
                <div class="card border-0 p-3 col-md-4 col-sm-12" v-for="venue in venues">
                    <div class="card-body border rounded">
                        <h5 class="card-title">@{{ venue.name }}</h5>
                        <p class="card-text">
                            <div v-for="address in venue.address">@{{ address }}</div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script>

    var VueApp = new Vue({
        el: "#app",
        data: {
            categories: [],
            venues: []
        },

        created() {
            this.getCategories()
        },

        methods: {

            getCategories() {
                var vm = this;

                $.ajax({
                    type: "GET",
                    url: "{{ route('api.categories') }}",
                    success: function (res) {
                        vm.categories = res.response.categories
                    },
                    error: function (req, status, err) {
                        alert("Birşeyler Yanlış Gitti, Durum: " + status + " ve Hata: " + err);
                    }
                });
            },

            getVenues(categoryId) {
                var vm = this;

                $.ajax({
                    type: "GET",
                    url: "{{ route('api.explore') }}",
                    data: {
                        near: 'valletta',
                        categoryId: categoryId,
                        radius: 100
                    },
                    success: function (res) {

                        if (res.response.totalResults === 0) {
                            vm.venues = [];
                            return;
                        }

                        var groups = res.response.groups;
                        var venues = [];

                        for (var index in groups) {
                            var group = groups[index];

                            for (var venueIndex in group.items) {
                                var venue = group.items[venueIndex];
                                venues.push({'name': venue.venue.name, 'address': venue.venue.location.formattedAddress});
                            }

                        }



                        vm.venues = venues;
                    },
                    error: function (req, status, err) {
                        alert("Birşeyler Yanlış Gitti, Durum: " + status + " ve Hata: " + err);
                    }
                });
            },

        }
    })


</script>

</body>
</html>
