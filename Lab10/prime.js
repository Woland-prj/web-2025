function getPrimes(start, end) {
    let res = new Array;
    if ((typeof(start) != "number") || (typeof(start) != "number") || (start >= end))
        return res;
    for (let i = start; i <= end; i++) {
        let isPrime = true;
    
        if (i < 2) {
            continue;
        }
    
        for (let j = 2; j <= Math.sqrt(i); j++) {
            if (i % j === 0) {
                isPrime = false;
                break;
            }
        }
    
        if (isPrime) {
            res.push(i)
        }
    }
    return res;
}

function isPrimeSingle(n) {
    if (typeof(n) == "number") {
        let primes = getPrimes(n - 1, n + 1);
        return primes.includes(n) ? true : false;
    }
    return false;
}

function isPrimeNumber(n) {
    if (typeof(n) == "number") {
        isPrimeSingle(n) ? console.log(n + " простое") : console.log(n + " не простое")
        return
    }

    if (Array.isArray(n)) {
        let primes = new Array
        let notPrimes = new Array
        n.forEach(num => isPrimeSingle(num) ? primes.push(num) : notPrimes.push(num))
        if (primes.length != 0) console.log(primes + " простые")
        if (notPrimes.length != 0) console.log(notPrimes + " не простые")
        return
    }

    console.log(n + " не число и не массив чисел")
}

let n = 5;
isPrimeNumber(n)