AFTER DELETE ON `@@@invoice` FOR EACH ROW
BEGIN
  DELETE FROM @@@invoicepay where idinvoice = OLD.id;
  CALL @@@sportsmen_calc_saldo(OLD.sportsmen);
  CALL @@@invoicepay_recalc(OLD.`sportsmen`);
END