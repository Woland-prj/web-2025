const numbers = [2, 5, 8, 10, 3]

// const result = numbers
//   .map(num => num * 3)        
//   .filter(num => num > 10)

function mapFilter(arr, mapFn, filterFn) {
    return arr.map(mapFn).filter(filterFn)
}

console.log(mapFilter(numbers, num => num * 3, num => num > 10))
