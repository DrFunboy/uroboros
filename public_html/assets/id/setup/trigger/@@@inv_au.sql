AFTER UPDATE ON `@@@invoice` FOR EACH ROW
IF (NEW.`sum`<>OLD.`sum`) THEN
  DELETE FROM @@@invoicepay where idinvoice = OLD.id;
  CALL @@@sportsmen_calc_saldo(NEW.`sportsmen`);
  CALL @@@invoicepay_recalc(NEW.`sportsmen`);
END IF