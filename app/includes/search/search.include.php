    <div class="results">
        <div class="row">
        	<div class="col s12 m6 l6">
        		searchbar
        	</div>
        	<div class="col s12 m6 l6">
                <div class="count"></div>
                <div class="page-results"></div>
                <div class="numbers"></div>
                <div class="pagination"></div>
        	</div>
        </div>
    </div>

    <div class="template hidden"></div>

  <script type="text/javascript">

    $(document).ready(function() {

        function somethingFresh(results){
            var template = $('.template').html();
            $.each(results.results,function(index,value){
                var html = Mustache.to_html(template, value);
                $('.page-results').append(html);
            });
            $('.count').html(results.count);
            $('.numbers').html(results.numbers);
            $('.pagination').html(results.pagination);
        }

        function thisisatemplate(data) {
            $('.template').html(data);
            $.getJSON('http://avidbrain.dev/search/algebra/85257/200/---/male/0/100/---/---/',somethingFresh);
        }

        $.get('/templates/mustache.template.html', thisisatemplate);




	});

  </script>
