<?php
class User extends Model
{
    public function getUserByUsername($username)
    {
        return $this->db->fetch("SELECT * FROM users WHERE username = ?", [$username]);
    }

    public function createUser($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $full_name = $data['first_name'] . ' ' . $data['last_name'];
        $this->db->execute("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)", [$full_name, $data['email'], $hashedPassword]);
    }
    public function createUserAdmin($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->db->execute("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)", [$data['full_name'], $data['email'], $hashedPassword]);
    }


    public function getUserByEmail($email)
    {
        $data = $this->db->fetch("SELECT * FROM users WHERE email = ?", [$email]) ?? [];

        return $data;
    }

    public function getUserById($id)
    {
        $data = $this->db->fetch("SELECT * FROM users WHERE id = ? LIMIT 1", [$id]) ?? NULL;

        return $data;
    }

    public function update($data)
    {
        $full_name = $data['full_name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_BCRYPT);

        $this->db->execute("UPDATE users SET full_name = ?, email = ?, password = ? WHERE id = ?", [$full_name, $email, $password, $_SESSION['user']['id']]);
    }

    public function all()
    {
        $data = $this->db->fetchAll("SELECT * FROM users");
        foreach ($data as $key => $value) {
            unset($data[$key]['password']);
        }
        return $data;
    }

    public function delete($id)
    {
        $this->db->execute("DELETE FROM users WHERE id = ?", [$id]);
    }

    public function totalUsers()
    {
        return $this->db->fetch("SELECT COUNT(*) as total FROM users")['total'];
    }
}
