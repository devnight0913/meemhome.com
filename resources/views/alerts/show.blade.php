@if ($message = Session::get('success'))
    <div class="alert bg-success text-light alert-dismissible shadow-sm rounded-3 fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
            <path fill="#ffffff"
                d="M10.6 13.8 8.425 11.625Q8.15 11.35 7.75 11.35Q7.35 11.35 7.05 11.65Q6.775 11.925 6.775 12.35Q6.775 12.775 7.05 13.05L9.9 15.9Q10.175 16.175 10.6 16.175Q11.025 16.175 11.3 15.9L16.975 10.225Q17.25 9.95 17.25 9.55Q17.25 9.15 16.95 8.85Q16.675 8.575 16.25 8.575Q15.825 8.575 15.55 8.85ZM12 22Q9.925 22 8.1 21.212Q6.275 20.425 4.925 19.075Q3.575 17.725 2.788 15.9Q2 14.075 2 12Q2 9.925 2.788 8.1Q3.575 6.275 4.925 4.925Q6.275 3.575 8.1 2.787Q9.925 2 12 2Q14.075 2 15.9 2.787Q17.725 3.575 19.075 4.925Q20.425 6.275 21.212 8.1Q22 9.925 22 12Q22 14.075 21.212 15.9Q20.425 17.725 19.075 19.075Q17.725 20.425 15.9 21.212Q14.075 22 12 22Z" />
        </svg> {{ $message }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert bg-danger text-light alert-dismissible shadow-sm rounded-3 fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
            <path fill="#ffffff"
                d="M7.7 16.3Q7.975 16.575 8.4 16.575Q8.825 16.575 9.1 16.3L12 13.4L14.925 16.325Q15.2 16.6 15.613 16.587Q16.025 16.575 16.3 16.3Q16.575 16.025 16.575 15.6Q16.575 15.175 16.3 14.9L13.4 12L16.325 9.075Q16.6 8.8 16.587 8.387Q16.575 7.975 16.3 7.7Q16.025 7.425 15.6 7.425Q15.175 7.425 14.9 7.7L12 10.6L9.075 7.675Q8.8 7.4 8.388 7.412Q7.975 7.425 7.7 7.7Q7.425 7.975 7.425 8.4Q7.425 8.825 7.7 9.1L10.6 12L7.675 14.925Q7.4 15.2 7.413 15.612Q7.425 16.025 7.7 16.3ZM12 22Q9.925 22 8.1 21.212Q6.275 20.425 4.925 19.075Q3.575 17.725 2.788 15.9Q2 14.075 2 12Q2 9.925 2.788 8.1Q3.575 6.275 4.925 4.925Q6.275 3.575 8.1 2.787Q9.925 2 12 2Q14.075 2 15.9 2.787Q17.725 3.575 19.075 4.925Q20.425 6.275 21.212 8.1Q22 9.925 22 12Q22 14.075 21.212 15.9Q20.425 17.725 19.075 19.075Q17.725 20.425 15.9 21.212Q14.075 22 12 22Z" />
        </svg> {{ $message }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($message = Session::get('status'))
    <div class="alert bg-info text-light alert-dismissible shadow-sm rounded-3 fade show" role="alert">
        STATUS: {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif