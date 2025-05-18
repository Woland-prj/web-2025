function generatePassword(size) {
    const lowerCase = "abcdefghijklmnopqrstuvwxyz"
    const upperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    const digits = "0123456789"
    const specialChars = "!@#$%^&*()_-+=<>?"
    
    const passwordArray = [
        lowerCase[Math.floor(Math.random() * lowerCase.length)],
        upperCase[Math.floor(Math.random() * upperCase.length)],
        digits[Math.floor(Math.random() * digits.length)],
        specialChars[Math.floor(Math.random() * specialChars.length)]
    ]
  
    const allCharacters = lowerCase + upperCase + digits + specialChars
    for (let i = passwordArray.length; i < size; i++) {
        passwordArray.push(allCharacters[Math.floor(Math.random() * allCharacters.length)])
    }
  
    passwordArray.sort(() => Math.random() - 0.5)
  
    return passwordArray.join("")
}
  
console.log(generatePassword(10))
  