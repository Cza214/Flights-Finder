$(function() {
    function validate(depp, arr, date) {
        if (!depp.length) {

        }
    }
        // Dircting

    function findDirectWindow(depp, arr, date, returnDate) {
        if (returnDate && returnDate.length !== 0) {
            window.location.pathname = '/flight/' + depp + '/' + arr + '/' + date + '/' + returnDate;
        } else {
            window.location.pathname = '/flight/' + depp + '/' + arr + '/' + date;
        }
    }
        // Get elements of path

    function getPath(action, type) {
        $result = [];
        var d = '';
        var elementsOfPath = window.location.pathname.split('/');
        if(type === 'return')
        {
            d = new Date(elementsOfPath[5]);
        } else {
            d = new Date(elementsOfPath[4]);
        }
        if (action === 'next') {
            d.setDate(d.getDate() + 1);
        } else if (action === 'back') {
            d.setDate(d.getDate() - 1);
        }
        console.log(elementsOfPath);
        $result['departure'] = elementsOfPath[2];
        $result['arrival'] = elementsOfPath[3];

        if(type === 'return')
        {
            $result['date'] = elementsOfPath[4];
            $result['returnDate'] = d.toISOString().split('T')[0]
        } else {
            $result['date'] = d.toISOString().split('T')[0];
            $result['returnDate'] = elementsOfPath[5];
        }

        return $result;
    }

    $(".find_button").on('click', function (e) {
        e.preventDefault();
        var depp = $(".departure_input").val();
        var arr = $(".arrival_input").val();
        var date = $(".date_input").val();
        var returnDate = $(".date_return_input").val();

        if(depp.length && arr.length && date.length){
            findDirectWindow(depp, arr, date, returnDate);
        } else {
            console.log(depp.length,arr.length,date.length);
        }
    });

    $(".nextDayFind_button").on('click', function () {
        var pathElements = getPath('next');
        console.log(pathElements);
        findDirectWindow(pathElements['departure'], pathElements['arrival'], pathElements['date'], pathElements['returnDate']);
    });

    $(".previousDayFind_button").on('click', function () {
        var pathElements = getPath('back');
        console.log(pathElements);
        findDirectWindow(pathElements['departure'], pathElements['arrival'], pathElements['date'], pathElements['returnDate']);
    });
    $(".returnNextDayFind_button").on('click', function () {
        var pathElements = getPath('next','return');
        console.log(pathElements);
        findDirectWindow(pathElements['departure'], pathElements['arrival'], pathElements['date'], pathElements['returnDate']);
    });

    $(".returnPreviousDayFind_button").on('click', function () {
        var pathElements = getPath('back','return');
        console.log(pathElements);
        findDirectWindow(pathElements['departure'], pathElements['arrival'], pathElements['date'], pathElements['returnDate']);
    });

    $(".addToFavorites").on('click', function(){
        var pathElements = getPath();
        window.location.pathname = '/favorites/new/'+pathElements['departure']+'/'+pathElements['arrival'];
    });

});