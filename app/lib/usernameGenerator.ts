export function generateUsername(): string {
    const firstDigit = Math.floor(Math.random() * 9) + 1;

    let otherDigits = '';
    for (let i = 0; i < 5; i++) {
        otherDigits += Math.floor(Math.random() * 10);
    }

    return firstDigit.toString() + otherDigits;
}
