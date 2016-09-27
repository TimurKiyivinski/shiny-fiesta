<?php

class Customer extends Model {
    public static function customer_exists($email) {
        $customers = (new Customer())->where('email', $email)->get();
        return is_object($customers);
    }

    public static function create($email, $name, $password, $phone) {
        // Create new customer instance
        $customer = new Customer();

        // Check if email is valid
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address");
        }

        // Check if this user has already registered
        if (self::customer_exists($email)) {
            throw new Exception("Customer with email $email already exists");
        }

        // Set customer data
        $customer->email = $email;
        $customer->name = $name;
        $customer->password = password_hash($password, PASSWORD_DEFAULT);
        $customer->phone = $phone;
        $customer->role = "customer";
        $customer->save();

        return $customer;
    }

    public static function authenticate($email, $password) {
        if (! self::customer_exists($email)) {
            throw new Exception("Customer with email $email doesn't exist");
        }

        $customer = (new Customer)->where('email', $email)->get();

        if (! password_verify($password, $customer->password)) {
            throw new Exception("Invalid password for email $email");
        } else {
            return $customer;
        }
    }
}
