document.addEventListener('DOMContentLoaded', function() {
    const accountNumberSelect = document.getElementById('account_number');
    const newAccountNumberInput = document.getElementById('new_account_number');

    function fetchAccounts() {
        fetch('fetch_accounts.php')
            .then(response => response.json())
            .then(data => {
                accountNumberSelect.innerHTML = '<option value="" selected disabled>Select Account Number</option>'; 
                data.forEach(account => {
                    const option = document.createElement('option');
                    option.value = account;
                    option.textContent = account;
                    accountNumberSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching account numbers:', error);
            });
    }
    
    fetchAccounts();

    accountNumberSelect.addEventListener('change', function() {
        if (accountNumberSelect.value === "") {
            newAccountNumberInput.style.display = 'inline-block';
            newAccountNumberInput.required = true;
        } else {
            newAccountNumberInput.style.display = 'none';
            newAccountNumberInput.required = false;
        }
    });
});
