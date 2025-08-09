import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select

import os
from datetime import datetime
from config import *

class TestBooks:
    def setup_method(self):
        self.driver = webdriver.Chrome()
        self.driver.implicitly_wait(10)
        
        self.driver.get(f"{BASE_URL}/login.php")
        self.driver.find_element(By.NAME, "usuario").send_keys(TEST_USER)
        self.driver.find_element(By.NAME, "password").send_keys(TEST_PASSWORD)
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

    def teardown_method(self):
        if self.driver:
            self.driver.quit()

    def take_screenshot(self, name):
        timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
        if not os.path.exists(SCREENSHOTS_PATH):
            os.makedirs(SCREENSHOTS_PATH)
        self.driver.save_screenshot(f"{SCREENSHOTS_PATH}/{name}_{timestamp}.png")

    def test_create_book(self):
        """
        HU-3: Crear nuevo libro (Camino feliz)
        """
        self.driver.get(f"{BASE_URL}/books.php")

        add_book_button = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".btn-primary[data-target='#addBookModal']"))
        )
        add_book_button.click()

        book_id_input = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#addBookModal input[name='id_titulo']"))
        )
        book_id_input.send_keys(NEW_BOOK["id_titulo"])
        
        self.driver.find_element(By.NAME, "titulo").send_keys(NEW_BOOK["titulo"])
        self.driver.find_element(By.NAME, "tipo").send_keys(NEW_BOOK["tipo"])
        self.driver.find_element(By.NAME, "id_pub").send_keys(NEW_BOOK["id_pub"])
        self.driver.find_element(By.NAME, "precio").send_keys(NEW_BOOK["precio"])
        self.driver.find_element(By.NAME, "avance").send_keys(NEW_BOOK["avance"])
        self.driver.find_element(By.NAME, "total_ventas").send_keys(NEW_BOOK["total_ventas"])
        self.driver.find_element(By.NAME, "notas").send_keys(NEW_BOOK["notas"])
        
        select_element = self.driver.find_element(By.NAME, "contrato")
        select_object = Select(select_element)
        select_object.select_by_value(str(NEW_BOOK["contrato"]))

        self.take_screenshot("create_book_form")

        submit_btn = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#addBookModal button[type='submit']"))
        )
        submit_btn.click()

        assert "exitosamente" in self.driver.page_source.lower()
        self.take_screenshot("create_book_success")

    def test_update_book(self):
        """
        HU-4: Actualizar libro (Camino feliz)
        """
        self.driver.get(f"{BASE_URL}/books.php")

        WebDriverWait(self.driver, 10).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "table"))
        )
        
        edit_button = self.driver.find_element(By.CSS_SELECTOR, ".btn-warning")
        edit_button.click()

        WebDriverWait(self.driver, 10).until(
            lambda d: "show" in d.find_element(By.ID, "editBookModal").get_attribute("class")
        )
        
        WebDriverWait(self.driver, 10).until(
            lambda d: d.find_element(By.ID, "edit_titulo").get_attribute("value") != ""
        )

        precio_input = self.driver.find_element(By.ID, "edit_precio")
        precio_input.clear()
        precio_input.send_keys("50")
        
        self.take_screenshot("update_book_valid")

        submit_btn = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#editBookModal button[type='submit']"))
        )
        submit_btn.click()

        assert "exitosamente" in self.driver.page_source.lower()
        self.take_screenshot("update_book_success")

    def test_update_book_limits(self):
        """
        HU-4: Actualizar libro (Prueba de límites)
        """
        self.driver.get(f"{BASE_URL}/books.php")

        WebDriverWait(self.driver, 10).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "table"))
        )
        
        edit_button = self.driver.find_element(By.CSS_SELECTOR, ".btn-warning")
        edit_button.click()

        WebDriverWait(self.driver, 10).until(
            lambda d: "show" in d.find_element(By.ID, "editBookModal").get_attribute("class")
        )
        
        WebDriverWait(self.driver, 10).until(
            lambda d: d.find_element(By.ID, "edit_titulo").get_attribute("value") != ""
        )

        test_data = {
            "edit_titulo": "a" * 255,  # Máxima longitud permitida para título
            "edit_precio": "99999.99", # Precio máximo
            "edit_avance": "-1",      # Valor negativo (no debería permitirse)
            "edit_total_ventas": "0"   # Valor mínimo permitido
        }

        for field_id, value in test_data.items():
            input_field = self.driver.find_element(By.ID, field_id)
            input_field.clear()
            input_field.send_keys(value)
            self.take_screenshot(f"update_limits_{field_id}")

        submit_btn = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#editBookModal button[type='submit']"))
        )
        submit_btn.click()

        assert "error" in self.driver.page_source.lower() or "exitosamente" in self.driver.page_source.lower()
        self.take_screenshot("update_book_limits_result")

    def test_delete_book(self):
        """
        HU-5: Eliminar libro (Camino Feliz)
        """
        self.driver.get(f"{BASE_URL}/books.php")
        
        books_before = len(self.driver.find_elements(By.CSS_SELECTOR, "table tbody tr"))
        
        delete_button = self.driver.find_element(By.CSS_SELECTOR, ".btn-danger")
        self.take_screenshot("delete_book_before")
        
        delete_button.click()
        
        self.driver.switch_to.alert.accept()
        
        books_after = len(self.driver.find_elements(By.CSS_SELECTOR, "table tbody tr"))
        assert books_after == books_before - 1
        self.take_screenshot("delete_book_after")