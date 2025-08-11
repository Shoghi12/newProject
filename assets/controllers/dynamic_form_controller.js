import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['nameInput', 'emailContainer'];
    
    connect() {
        this.toggleEmailVisibility();
    }
    
    onNameInput() {
        this.toggleEmailVisibility();
    }
    
    toggleEmailVisibility() {
        const name = this.nameInputTarget.value.trim().toLowerCase();
        this.emailContainerTarget.hidden = (name !== 'john');
    }
}