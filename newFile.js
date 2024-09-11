{
    var isPerformanceSupported = (
        window.performance &&
        window.performance.now &&
        window.performance.timing &&
        window.performance.timing.navigationStart
    );

    var timeStampInMs = (
        isPerformanceSupported ?
            window.performance.now() +
            window.performance.timing.navigationStart :
            Date.now()
    );

    console.log(timeStampInMs, Date.now());
}
