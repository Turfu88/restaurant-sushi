export interface EstablishmentForm {
    id?: number;
    name: string;
    address: string;
    availableSeats: number;
    timeLimitBeforeCancel: number;
    open: boolean;
    openingAdvancedBookingDays: number;
}
